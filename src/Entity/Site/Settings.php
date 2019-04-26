<?php

namespace Tecnogo\MeliSdk\Entity\Site;

use Tecnogo\MeliSdk\Entity\AbstractEntity;

/**
 * Class Settings
 *
 * @package Tecnogo\MeliSdk\Entity\Site
 */
final class Settings extends AbstractEntity
{
    /**
     * @return array
     */
    public function identificationTypes()
    {
        return $this->get('identification_types');
    }

    /**
     * @return array
     */
    public function taxpayerTypes()
    {
        return $this->get('taxpayer_types');
    }

    /**
     * @return array
     */
    public function identificationTypeRules()
    {
        return $this->get('identification_types_rules');
    }
}
