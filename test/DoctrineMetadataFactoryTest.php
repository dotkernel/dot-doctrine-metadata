<?php

declare(strict_types=1);

namespace DotTest\DoctrineMetadata;

use Dot\DoctrineMetadata\Factory\DoctrineMetadataMapFactory;
use Mezzio\Hal\Metadata\Exception\InvalidConfigException;
use Mezzio\Hal\Metadata\MetadataMap;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class DoctrineMetadataFactoryTest extends TestCase
{
    private DoctrineMetadataMapFactory $doctrineMetadataMapFactory;
    private ContainerInterface|MockObject $container;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        $this->doctrineMetadataMapFactory = new DoctrineMetadataMapFactory();
        $this->container                  = $this->createMock(ContainerInterface::class);
    }

    public function testStripNamespaceFromClass(): void
    {
        $factory            = $this->doctrineMetadataMapFactory;
        $classWithNamespace = 'Dot\DotTest\DoctrineMetadata';
        $expectedResult     = 'DoctrineMetadata';
        $actualResult       = $factory->stripNamespaceFromClass($classWithNamespace);
        $this->assertSame($expectedResult, $actualResult);
    }

    public function testInvokeReturnsMetadataMap(): void
    {
        $config = [
            MetadataMap::class => [],
            'mezzio-hal'       => [
                'metadata-factories' => [],
            ],
        ];
        $this->container->expects($this->once())
            ->method('has')
            ->with('config')
            ->willReturn(true);

        $this->container->expects($this->once())
            ->method('get')
            ->with('config')
            ->willReturn($config);
        $result = $this->doctrineMetadataMapFactory->__invoke($this->container);
        $this->assertInstanceOf(MetadataMap::class, $result);
    }

    public function testInvokeThrowsExceptionForNonArrayMetadataMapConfig(): void
    {
        $this->container->expects($this->once())
            ->method('has')
            ->with('config')
            ->willReturn(true);
        $this->container->expects($this->once())
            ->method('get')
            ->with('config')
            ->willReturn('string');
        $this->expectException(InvalidConfigException::class);
        ($this->doctrineMetadataMapFactory)($this->container);
    }

    public function testPopulateMetadataMapFromConfig(): void
    {
        $factory           = $this->doctrineMetadataMapFactory;
        $metadataMap       = new MetadataMap();
        $metadataMapConfig = [];
        $metadataFactories = [];
        $result            = $factory->populateMetadataMapFromConfig(
            $metadataMap,
            $metadataMapConfig,
            $metadataFactories
        );
        $this->assertInstanceOf(MetadataMap::class, $result);
    }

    public function testInjectMetadataWithNonMetadataClass(): void
    {
        $factory           = $this->doctrineMetadataMapFactory;
        $metadataMap       = new MetadataMap();
        $metadata          = [
            '__class__' => 'NonMetadataClass',
        ];
        $metadataFactories = [];
        $this->expectException(InvalidConfigException::class);
        $factory->injectMetadata($metadataMap, $metadata, $metadataFactories);
    }

    public function testCreateMetadataViaFactoryMethodThrowsException(): void
    {
        $metadataClass = 'DotTest\DoctrineMetadata';
        $metadata      = [];
        $factory       = $this->doctrineMetadataMapFactory;
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessageMatches('/does not know how to construct a .* instance/');
        $factory->createMetadataViaFactoryMethod($metadataClass, $metadata);
    }
}
