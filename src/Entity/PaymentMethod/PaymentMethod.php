<?php

namespace Tecnogo\MeliSdk\Entity\PaymentMethod;

use Tecnogo\MeliSdk\Entity\AbstractEntity;

/**
 * Class PaymentMethod
 *
 * @package Tecnogo\MeliSdk\Entity\PaymentMethods
 */
final class PaymentMethod extends AbstractEntity
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
