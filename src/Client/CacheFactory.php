<?php

namespace Tecnogo\MeliSdk\Client;

use Psr\SimpleCache\CacheInterface;

/**
 * Class CacheFactory
 *
 * @package MeliSdk\Client
 */
class CacheFactory implements CacheFactoryInterface
{
    const DEFAULT_TTL_IN_SECONDS = 180;

    /**
     * @var Factory
     */
    private $factory;

    /**
     * @var array<string, CacheInterface>
     */
    private $instances = [];

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param $namespace
     * @param int|null $ttl
     * @return CacheInterface
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    public function get($namespace, $ttl = null)
    {
        if (!isset($this->instances[$namespace])) {
            $this->instances[$namespace] = $this->make($namespace, $ttl);
        }

        return $this->instances[$namespace];
    }

    /**
     * @param $namespace
     * @param int|null $ttl
     * @return CacheInterface
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    private function make($namespace, $ttl = self::DEFAULT_TTL_IN_SECONDS)
    {
        $overridableCache = $this->factory->make(CacheInterface::class);

        return $this->factory->make(Cache::class, [
            'cache' => $overridableCache,
            'namespace' => $namespace,
            'ttl' => $ttl
        ]);
    }
}
