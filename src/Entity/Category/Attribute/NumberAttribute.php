<?php

namespace Tecnogo\MeliSdk\Entity\Category\Attribute;

/**
 * Class NumberAttribute
 *
 * @package Tecnogo\MeliSdk\Entity\Category\Attribute
 */
final class NumberAttribute extends AbstractAttribute
{
    /**
     * @return string
     */
    public function type()
    {
        return AttributeType::NUMBER;
    }
}
