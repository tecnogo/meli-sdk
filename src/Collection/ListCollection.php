<?php

namespace Tecnogo\MeliSdk\Collection;


use ArrayIterator;
use Traversable;

/**
 * Class ListCollection
 *
 * @package Tecnogo\MeliSdk\Collection
 */
class ListCollection implements ArrayList, \ArrayAccess, \IteratorAggregate
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @param array $items
     * @return static
     */
    public static function make($items = [], $mapper = null)
    {
        if (is_callable($mapper)) {
            $items = array_map(function ($item) use ($mapper) {
                return $mapper($item);
            }, $items);
        }

        return new static($items);
    }

    public function __construct(array $items = [])
    {
        $this->items = array_values($items);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * @param int $offset
     * @param int $length
     * @return static
     */
    public function slice($offset, $length = null)
    {
        return new static(array_slice($this->items, $offset, $length));
    }

    /**
     * @param $item
     * @return static
     */
    public function add($item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function first()
    {
        return $this->items[0] ?? null;
    }

    /**
     * @return mixed|null
     */
    public function last()
    {
        return $this->reverse()->first();
    }

    /**
     * @param $callable
     * @return void
     */
    public function each($callable)
    {
        foreach ($this->items as $index => $item) {
            $callable($item, $index, $this);
        }
    }

    /**
     * @param $key
     * @return static
     */
    public function pluck($key)
    {
        return $this->map(function ($item) use ($key) {
            return $item->{$key} ?? $item[$key] ?? null;
        });
    }

    /**
     * @param $callable
     * @return static
     */
    public function map($callable)
    {
        return new static(array_map($callable, $this->toArray()));
    }

    /**
     * @param $callable
     * @return static
     */
    public function filter($callable)
    {
        $filtered = new static;

        $this->each(function ($item, $index, $collection) use ($callable, $filtered) {
            $pass = $callable($item, $index, $collection);

            if ($pass) {
                $filtered->add($item);
            }
        });

        return $filtered;
    }

    /**
     * @return static
     */
    public function unique()
    {
        $added = [];

        return $this->filter(function ($item) use (&$added) {
            if (!in_array($item, $added)) {
                $added[] = $item;
                return true;
            }

            return false;
        });
    }

    /**
     * @param $callable
     * @return bool
     */
    public function has($callable)
    {
        return in_array($callable, $this->items) || !$this->filter($callable)->empty();
    }

    /**
     * @param $callable
     * @param mixed $initialState
     * @return mixed
     */
    public function reduce($callable, $initialState = null)
    {
        return array_reduce($this->items, $callable, $initialState);
    }

    /**
     * @return static
     */
    public function reverse()
    {
        return new static(array_reverse($this->items));
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @return int
     */
    public function isEmpty()
    {
        return $this->count() === 0;
    }

    /**
     * Invokes the passed method in every entry of the collection
     *
     * @param string $methodName
     * @param array $arguments
     * @return $this
     */
    protected function invoke($methodName, $arguments = [])
    {
        $this->each(function ($entity) use ($methodName, $arguments) {
            $entity->{$methodName}(...$arguments);
        });

        return $this;
    }

    /**
     * Whether a offset exists
     * @link https://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * Offset to retrieve
     * @link https://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset] ?? null;
    }

    /**
     * Offset to set
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    /**
     * Offset to unset
     * @link https://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * Retrieve an external iterator
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new ArrayIterator($this->toArray());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->items);
    }
}