<?php

namespace Tecnogo\MeliSdk\Entity\Category\Attribute;

/**
 * Class NumberUnitAttribute
 *
 * @package Tecnogo\MeliSdk\Entity\Category\Attribute
 */
final class NumberUnitAttribute extends AbstractAttribute implements Attribute
{
    /**
     * @return string
     */
    public function type()
    {
        return AttributeType::NUMBER_UNIT;
    }

    /**
     * @return array
     */
    public function allowedUnits()
    {
        return $this->get('allowed_units');
    }

    /**
     * @return mixed
     */
    public function defaultUnit()
    {
        return $this->get('default_unit');
    }
}
