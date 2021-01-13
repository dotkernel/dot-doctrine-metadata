<?php


namespace Dot\DoctrineMetadata;

use Dot\DoctrineMetadata\Factory\DoctrineMetadataMapFactory;
use Mezzio\Hal\Metadata\MetadataMap;

class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            'factories' => [
                MetadataMap::class => DoctrineMetadataMapFactory::class,
            ],
        ];
    }
}