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
     * @return CacheInterface
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    public function get($namespace)
    {
        if (!isset($this->instances[$namespace])) {
            $this->instances[$namespace] = $this->make($namespace);
        }

        return $this->instances[$namespace];
    }

    /**
     * @param $namespace
     * @return CacheInterface
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    private function make($namespace)
    {
        $overridableCache = $this->factory->make(CacheInterface::class);

        return $this->factory->make(Cache::class, [
            'cache' => $overridableCache,
            'namespace' => $namespace,
        ]);
    }
}
