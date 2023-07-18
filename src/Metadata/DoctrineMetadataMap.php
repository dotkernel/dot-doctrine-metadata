<?php

declare(strict_types=1);

namespace Dot\DoctrineMetadata\Metadata;

use Doctrine\Common\Util\ClassUtils;
use Mezzio\Hal\Metadata\AbstractMetadata;
use Mezzio\Hal\Metadata\MetadataMap;

class DoctrineMetadataMap extends MetadataMap
{
    /**
     * Checks if the given $class namespace exists in the metadata,
     * ensuring it will always be a real class namespace, not a proxy representation.
     */
    public function has(string $class): bool
    {
        $class = ClassUtils::getRealClass($class);
        return parent::has($class);
    }

    /**
     * Retrieves the metadata for the given $class namespace,
     * ensuring it will always be a real class namespace, not a proxy representation.
     */
    public function get(string $class): AbstractMetadata
    {
        $class = ClassUtils::getRealClass($class);
        return parent::get($class);
    }
}
