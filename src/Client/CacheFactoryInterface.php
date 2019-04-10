<?php

namespace Tecnogo\MeliSdk\Client;


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
     * @param int|null $ttl
     * @return CacheInterface
     */
    public function get($namespace, $ttl = null);
}