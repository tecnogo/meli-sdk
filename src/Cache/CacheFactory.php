<?php

namespace Tecnogo\MeliSdk\Cache;

use Psr\SimpleCache\CacheInterface;
use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Config\Config;

/**
 * Class CacheFactory
 *
 * @package MeliSdk\Client
 */
class CacheFactory implements CacheFactoryInterface
{
    const SHARED_CACHE_KEY = 'shared';

    /**
     * @var Config
     */
    private $config;
    /**
     * @var CacheInterface
     */
    private $sharedCache;
    /**
     * @var Factory
     */
    private $factory;

    public function __construct(Factory $factory, Config $config)
    {
        $this->config = $config;
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
        return $this->config->getCache($namespace) ?? $this->getSharedCache();
    }

    /**
     * @return mixed|CacheInterface|null
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    private function getSharedCache()
    {
        if (!$this->sharedCache) {
            $this->sharedCache = $this->config->getCache('shared') ??
                $this->factory->make(CacheInterface::class);
        }

        return $this->sharedCache;
    }
}
