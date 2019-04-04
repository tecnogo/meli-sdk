<?php

namespace Tecnogo\MeliSdk\Entity\Picture;


use Tecnogo\MeliSdk\Collection\ListCollection;

/**
 * Class VariationCollection
 *
 * @package Tecnogo\MeliSdk\Picture
 *
 * @method Variation first()
 * @method Variation last()
 */
class VariationCollection extends ListCollection
{
    /**
     * @return array
     */
    public function sizes()
    {
        return $this->pluck('size')->unique()->toArray();
    }
}