<?php

declare(strict_types=1);

namespace DotTest\DoctrineMetadata;

use Dot\DoctrineMetadata\Metadata\DoctrineMetadataMap;
use Mezzio\Hal\Metadata\Exception\UndefinedMetadataException;
use PHPUnit\Framework\TestCase;

class DoctrineMetadataMapTest extends TestCase
{
    public function testHasReturnsFalseForNonExistingClass(): void
    {
        $metadataMap = new DoctrineMetadataMap();
        $result      = $metadataMap->has('NonExistingClass');
        $this->assertFalse($result);
    }

    public function testGetThrowsExceptionForNonExistingClass(): void
    {
        $metadataMap = new DoctrineMetadataMap();
        $this->expectException(UndefinedMetadataException::class);
        $this->expectExceptionMessage('Unable to retrieve metadata for "NonExistingClass"; no matching metadata found');
        $metadataMap->get('NonExistingClass');
    }
}
