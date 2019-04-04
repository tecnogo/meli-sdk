<?php

namespace Tecnogo\MeliSdk\Entity\Item;

use Tecnogo\MeliSdk\Entity\AbstractEntity;

/**
 * Class Attribute
 *
 * @package Tecnogo\MeliSdk\Entity\Item
 *
 * @internal
 */
final class Attribute extends AbstractEntity
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
    public function name()
    {
        return $this->get('name');
    }

    /**
     * @return string|null
     */
    public function valueId()
    {
        return $this->get('value_id');
    }

    /**
     * @return string|null
     */
    public function valueName()
    {
        return $this->get('value_name');
    }

    /**
     * @return string|null
     */
    public function attributeGroupId()
    {
        return $this->get('attribute_group_id');
    }

    /**
     * @return string|null
     */
    public function attributeGroupName()
    {
        return $this->get('attribute_group_name');
    }
}
