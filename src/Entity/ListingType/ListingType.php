<?php

namespace Tecnogo\MeliSdk\Entity\ListingType;

use Tecnogo\MeliSdk\Entity\AbstractEntity;

/**
 * Class ListingType
 *
 * @package Tecnogo\MeliSdk\Entity\ListingTypes
 */
final class ListingType extends AbstractEntity
{
    /**
     * @return string
     */
    public function id()
    {
        return $this->get('id');
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->get('name');
    }
}
