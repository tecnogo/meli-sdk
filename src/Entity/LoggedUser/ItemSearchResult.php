<?php

namespace Tecnogo\MeliSdk\Entity\LoggedUser;

use ArrayIterator;
use Tecnogo\MeliSdk\Collection\ArrayList;
use Tecnogo\MeliSdk\Entity\AbstractEntity;
use Tecnogo\MeliSdk\Entity\Item\Collection;
use Tecnogo\MeliSdk\Entity\Item\Item;
use Traversable;

class ItemSearchResult extends AbstractEntity implements ArrayList
{
    /**
     * @return int
     */
    public function page()
    {
        $paging = $this->get('paging');

        return ($paging['offset'] / $paging['limit']) + 1;
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->get('paging.total');
    }

    /**
     * @return Collection
     */
    public function items()
    {
        return Collection::make($this->get('results', []), function ($id) {
            return $this->client->item($id);
        });
    }

    /**
     * @return Item
     */
    public function first()
    {
        return $this->items()->first();
    }

    /**
     * @return Item
     */
    public function last()
    {
        return $this->items()->last();
    }

    /**
     * @param $callable
     * @return void
     */
    public function each($callable)
    {
        $this->items()->each($callable);
    }

    /**
     * @param $callable
     * @return Collection
     */
    public function map($callable)
    {
        return $this->items()->map($callable);
    }

    /**
     * @param $callable
     * @return Collection
     */
    public function filter($callable)
    {
        return $this->items()->filter($callable);
    }

    /**
     * @param $callable
     * @return bool
     */
    public function has($callable)
    {
        return $this->items()->has($callable);
    }

    /**
     * @param $callable
     * @param mixed $initialState
     * @return mixed
     */
    public function reduce($callable, $initialState = null)
    {
        return $this->items()->reduce($callable, $initialState);
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
        return $this->items()->offsetExists($offset);
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
        return $this->items()->offsetGet($offset);
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
        $this->items()->offsetSet($offset, $value);
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
        $this->items()->offsetUnset($offset);
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

    private function toArray()
    {
        return $this->items()->toArray();
    }
}