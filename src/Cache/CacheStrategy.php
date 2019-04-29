<?php

namespace Tecnogo\MeliSdk\Cache;

use Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy;
use Tecnogo\MeliSdk\Config\Config;

/**
 * Class CacheStrategy
 *
 * @package Tecnogo\MeliSdk\Client
 *
 * @see Config
 */
final class CacheStrategy
{
    const NO_CACHE = 'NO_CACHE';
    const BRIEF = 'BRIEF'; // 90 seconds
    const LONG = 'LONG'; // 1 hour
    const DAY = 'DAY'; // 24 hours
    const FOREVER = 'FOREVER'; // and ever!

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
