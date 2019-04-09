<?php

namespace Tecnogo\MeliSdk\Test\Unit\Collection;


use PHPUnit\Framework\TestCase;
use Tecnogo\MeliSdk\Collection\ListCollection;

class TestCollection extends TestCase
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
        $colle = new ListCollection(['foo', 'bar']);

        $this->assertFalse($colle->isEmpty());
    }

    public function testCollectionIsConstructed()
    {
        $collection = new ListCollection('foo');
        $this->assertSame(['foo'], $collection->toArray());

        $collection = new ListCollection(2);
        $this->assertSame([2], $collection->toArray());
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

        $collection->offsetSet(null, 'qux');
        $this->assertEquals('qux', $collection[2]);
    }
}
