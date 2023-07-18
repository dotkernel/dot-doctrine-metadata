<?php

declare(strict_types=1);

namespace Dot\DoctrineMetadata;

use Dot\DoctrineMetadata\Factory\DoctrineMetadataMapFactory;
use Mezzio\Hal\Metadata\MetadataMap;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'factories' => [
                MetadataMap::class => DoctrineMetadataMapFactory::class,
            ],
        ];
    }
}
