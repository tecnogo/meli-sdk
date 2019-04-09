<?php

namespace Tecnogo\MeliSdk\Test\Unit\Collection;


use PHPUnit\Framework\TestCase;
use Tecnogo\MeliSdk\Collection\ListCollection;

class CollectionTest extends TestCase
{
    public function testFirstReturnsFirstItemInCollection()
    {
        $collection = new ListCollection(['a', 'b']);

        $this->assertEquals('a', $collection->first());
    }

    public function testLastReturnsLastItemInCollection()
    {
        $collection = new ListCollection(['foo', 'bar']);
        $this->assertEquals('bar', $collection->last());
    }

    public function testEmptyCollectionIsEmpty()
    {
        $this->assertTrue((new ListCollection)->isEmpty());
    }

    public function testEmptyCollectionIsNotEmpty()
    {
        $collection = new ListCollection(['foo', 'bar']);

        $this->assertFalse($collection->isEmpty());
    }

    public function testArrayAccessOffsetExists()
    {
        $collection = new ListCollection(['wubba', 'lubba']);
        $this->assertTrue($collection->offsetExists(0));
        $this->assertTrue($collection->offsetExists(1));
        $this->assertFalse($collection->offsetExists(1000));
    }

    public function testArrayAccessOffsetGet()
    {
        $c = new ListCollection(['foo', 'bar']);
        $this->assertEquals('foo', $c->offsetGet(0));
        $this->assertEquals('bar', $c->offsetGet(1));
    }

    public function testArrayAccessOffsetSet()
    {
        $collection = new ListCollection(['foo', 'foo']);

        $collection->offsetSet(1, 'bar');
        $this->assertEquals('bar', $collection[1]);
    }

    public function testMapEmptyCollection()
    {
        $collection = new ListCollection();

        $newCollection = $collection->map(function($c) { return $c * $c; });

        $this->assertInstanceOf(ListCollection::class, $newCollection);
        $this->assertCount(0, $newCollection);
    }

    public function testMapNonEmptyCollection()
    {
        $collection = new ListCollection([1, 2, 3, 4, 5]);

        $newCollection = $collection->map(function($c) { return $c * $c; });

        $this->assertInstanceOf(ListCollection::class, $newCollection);
        $this->assertCount(5, $newCollection);
    }
}
