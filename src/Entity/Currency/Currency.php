<?php

namespace Tecnogo\MeliSdk\Entity\Currency;

use Tecnogo\MeliSdk\Entity\AbstractEntity;

/**
 * Class Currency
 *
 * @package Tecnogo\MeliSdk\Entity\Currency
 *
 * @internal
 */
final class Currency extends AbstractEntity
{
    /**
     * @return string|null
     */
    public function id()
    {
        return $this->get('id');
    }

    /**
     * @return string|null
     */
    public function symbol()
    {
        return $this->get('symbol');
    }

    /**
     * @return string|null
     */
    public function description()
    {
        return $this->get('description');
    }

    /**
     * @return string|null
     */
    public function decimalPlaces()
    {
        return $this->get('decimal_places');
    }
}
