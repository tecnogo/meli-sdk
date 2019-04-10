<?php

namespace Tecnogo\MeliSdk\Entity\Category\Attribute;

/**
 * Interface Attribute
 *
 * @package Tecnogo\MeliSdk\Entity\Category\Attribute
 */
interface Attribute
{
    /**
     * @return string
     */
    public function id();

    /**
     * @return string
     */
    public function name();

    /**
     * @return string
     */
    public function type();
}
