<?php


namespace Dot\DoctrineMetadata\Metadata;

use Mezzio\Hal\Metadata\MetadataMap;
use Doctrine\Common\Util\ClassUtils;
use Mezzio\Hal\Metadata\AbstractMetadata;

class DoctrineMetadataMap extends MetadataMap
{
    /**
     * Overwrites the $class namespace, ensuring it will always be a real class namespace, not a proxy representation.
     *
     * @param string $class
     * @return bool
     */
    public function has(string $class) : bool
    {
        $class = ClassUtils::getRealClass($class);
        return parent::has($class);
    }

    /**
     * Overwrites the $class namespace, ensuring it will always be a real class namespace, not a proxy representation.
     *
     * @param string $class
     * @return AbstractMetadata
     */
    public function get(string $class) : AbstractMetadata {
        $class = ClassUtils::getRealClass($class);
        return parent::get($class);
    }
}