<?php

namespace Tecnogo\MeliSdk\Entity\Category\Attribute;

/**
 * Class AttributeType
 *
 * @package Tecnogo\MeliSdk\Entity\Category\Attribute
 */
final class AttributeType
{
    const BOOLEAN = 'boolean';
    const LIST = 'list';
    const NUMBER = 'number';
    const NUMBER_UNIT = 'number_unit';
    const STRING = 'string';

    /**
     * @param $type
     * @return bool
     */
    public static function validate($type)
    {
        $type = strtoupper($type);

        return defined("static::$type");
    }
}
