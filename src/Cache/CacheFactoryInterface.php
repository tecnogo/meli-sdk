<?php

namespace Tecnogo\MeliSdk\Cache;

use Psr\SimpleCache\CacheInterface;

/**
 * Class CacheFactory
 *
 * @package MeliSdk\Client
 */
interface CacheFactoryInterface
{
    /**
     * @param $namespace
     * @return CacheInterface
     */
    public function get($namespace);
}
