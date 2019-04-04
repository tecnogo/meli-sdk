<?php

namespace Tecnogo\MeliSdk\Collection;

interface ArrayList
{
    public function first();

    public function last();

    /**
     * @param $callable
     * @return void
     */
    public function each($callable);

    /**
     * @param $callable
     * @return $this
     */
    public function map($callable);

    /**
     * @param $callable
     * @return $this
     */
    public function filter($callable);

    /**
     * @param $callable
     * @return bool
     */
    public function has($callable);

    /**
     * @param $callable
     * @param mixed $initialState
     * @return mixed
     */
    public function reduce($callable, $initialState = null);

    /**
     * @return int
     */
    public function count();
}