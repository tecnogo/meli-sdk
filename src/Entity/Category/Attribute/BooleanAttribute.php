<?php

namespace Tecnogo\MeliSdk\Entity\Category\Attribute;

/**
 * Class BooleanAttribute
 *
 * @package Tecnogo\MeliSdk\Entity\Category\Attribute
 */
final class BooleanAttribute extends AbstractAttribute
{
    /**
     * @return string
     */
    public function type()
    {
        return AttributeType::BOOLEAN;
    }
}
