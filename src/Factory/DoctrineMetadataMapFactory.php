<?php

declare(strict_types=1);

namespace Dot\DoctrineMetadata\Factory;

use Dot\DoctrineMetadata\Metadata\DoctrineMetadataMap;
use Mezzio\Hal\Metadata\AbstractMetadata;
use Mezzio\Hal\Metadata\Exception\InvalidConfigException;
use Mezzio\Hal\Metadata\MetadataFactoryInterface;
use Mezzio\Hal\Metadata\MetadataMap;
use Psr\Container\ContainerInterface;

use function array_pop;
use function class_exists;
use function class_implements;
use function class_parents;
use function explode;
use function in_array;
use function is_array;
use function method_exists;
use function sprintf;

class DoctrineMetadataMapFactory
{
    public function __invoke(ContainerInterface $container): MetadataMap
    {
        $config            = $container->has('config') ? $container->get('config') : [];
        $metadataMapConfig = $config[MetadataMap::class] ?? null;

        if (! is_array($metadataMapConfig)) {
            throw InvalidConfigException::dueToNonArray($metadataMapConfig);
        }

        $metadataFactories = $config['mezzio-hal']['metadata-factories'] ?? [];
        return $this->populateMetadataMapFromConfig(
            new DoctrineMetadataMap(),
            $metadataMapConfig,
            $metadataFactories
        );
    }

    public function populateMetadataMapFromConfig(
        MetadataMap $metadataMap,
        array $metadataMapConfig,
        array $metadataFactories
    ): MetadataMap {
        foreach ($metadataMapConfig as $metadata) {
            if (! is_array($metadata)) {
                throw InvalidConfigException::dueToNonArrayMetadata($metadata);
            }
            $this->injectMetadata($metadataMap, $metadata, $metadataFactories);
        }
        return $metadataMap;
    }

    public function injectMetadata(MetadataMap $metadataMap, array $metadata, array $metadataFactories): void
    {
        if (! isset($metadata['__class__'])) {
            throw InvalidConfigException::dueToMissingMetadataClass();
        }

        if (! class_exists($metadata['__class__'])) {
            throw InvalidConfigException::dueToInvalidMetadataClass($metadata['__class__']);
        }

        $metadataClass = $metadata['__class__'];
        if (! in_array(AbstractMetadata::class, class_parents($metadataClass), true)) {
            throw InvalidConfigException::dueToNonMetadataClass($metadataClass);
        }

        if (isset($metadataFactories[$metadataClass])) {
            // A factory was registered. Use it!
            $metadataMap->add($this->createMetadataViaFactoryClass(
                $metadataClass,
                $metadata,
                $metadataFactories[$metadataClass]
            ));
            return;
        }

        // No factory was registered. Use the deprecated factory method.
        $metadataMap->add($this->createMetadataViaFactoryMethod(
            $metadataClass,
            $metadata
        ));
    }

    /**
     * Uses the registered factory class to create the metadata instance.
     */
    public function createMetadataViaFactoryClass(
        string $metadataClass,
        array $metadata,
        string $factoryClass
    ): AbstractMetadata {
        if (! in_array(MetadataFactoryInterface::class, class_implements($factoryClass), true)) {
            throw InvalidConfigException::dueToInvalidMetadataFactoryClass($factoryClass);
        }

        $factory = new $factoryClass();
        /** @var MetadataFactoryInterface $factory */
        return $factory->createMetadata($metadataClass, $metadata);
    }

    /**
     * Call the factory method in this class namend "createMyMetadata(array $metadata)".
     * This function is to ensure backwards compatibility with versions prior to 0.6.0.
     */
    public function createMetadataViaFactoryMethod(string $metadataClass, array $metadata): AbstractMetadata
    {
        $normalizedClass = $this->stripNamespaceFromClass($metadataClass);
        $method          = sprintf('create%s', $normalizedClass);

        if (! method_exists($this, $method)) {
            throw InvalidConfigException::dueToUnrecognizedMetadataClass($metadataClass);
        }

        return $this->$method($metadata);
    }

    public function stripNamespaceFromClass(string $class): string
    {
        $segments = explode('\\', $class);
        return array_pop($segments);
    }
}
