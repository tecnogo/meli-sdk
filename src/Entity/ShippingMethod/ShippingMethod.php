<?php

namespace Tecnogo\MeliSdk\Entity\ShippingMethod;

use Tecnogo\MeliSdk\Entity\AbstractEntity;

/**
 * Class ShippingMethod
 *
 * @package Tecnogo\MeliSdk\Entity\ShippingMethod
 */
final class ShippingMethod extends AbstractEntity
{
    /**
     * @return int|null
     */
    public function id()
    {
        return $this->get('id');
    }

    /**
     * @return string|null
     */
    public function name()
    {
        return $this->get('name');
    }
}
