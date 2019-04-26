<?php

namespace Tecnogo\MeliSdk\Cache;

use Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy;

/**
 * Class CacheStrategy
 *
 * @package Tecnogo\MeliSdk\Client
 */
final class CacheStrategy
{
    const NO_CACHE = 'NO_CACHE';
    const BRIEF = 'BRIEF';
    const LONG = 'LONG';
    const FOREVER = 'FOREVER';

    /**
     * @param $strategy
     * @throws InvalidCacheStrategy
     */
    public static function assert($strategy)
    {
        if (!defined("self::$strategy")) {
            throw new InvalidCacheStrategy($strategy);
        }
    }
}
