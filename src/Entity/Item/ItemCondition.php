<?php

namespace Tecnogo\MeliSdk\Entity\Item;

/**
 * Class ItemCondition
 *
 * @package Tecnogo\MeliSdk\Entity\Item
 */
final class ItemCondition
{
    const NEW = 'new';
    const NOT_SPECIFIED = 'not_specified';
    const USED = 'used';

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
