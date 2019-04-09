<?php

namespace Tecnogo\MeliSdk\Entity\Category\Attribute;

/**
 * Class ListAttribute
 *
 * @package Tecnogo\MeliSdk\Entity\Category\Attribute
 */
final class ListAttribute extends AbstractAttribute implements Attribute
{
    /**
     * @return string
     */
    public function type()
    {
        return AttributeType::LIST;
    }

    /**
     * @return array
     */
    public function values()
    {
        return $this->get('values');
    }
}
