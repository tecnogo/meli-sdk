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

    /**
     * @return string|null
     */
    public function thumbnail()
    {
        return $this->get('secure_thumbnail');
    }

    /**
     * @return array|null
     */
    public function payerCosts()
    {
        return $this->get('payer_costs', []);
    }

    /**
     * @return array|null
     */
    public function cardConfiguration()
    {
        return $this->get('card_configuration', []);
    }
}
