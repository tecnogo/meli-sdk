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
     * @return CacheInterface
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function get($namespace);
}