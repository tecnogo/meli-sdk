<?php

namespace Tecnogo\MeliSdk\Entity\Category\Attribute;

/**
 * Class StringAttribute
 *
 * @package Tecnogo\MeliSdk\Entity\Category\Attribute
 */
final class StringAttribute extends AbstractAttribute implements Attribute
{
    /**
     * @return string
     */
    public function type()
    {
        return AttributeType::STRING;
    }
}
