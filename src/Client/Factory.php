<?php

namespace Tecnogo\MeliSdk\Client;

use Illuminate\Contracts\Container\Container;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Tecnogo\MeliSdk\Config\AccessToken;
use Tecnogo\MeliSdk\Config\AppId;
use Tecnogo\MeliSdk\Config\AppSecret;
use Tecnogo\MeliSdk\Config\Config;
use Tecnogo\MeliSdk\Config\SiteId;
use Tecnogo\MeliSdk\Exception\ContainerException;
use Tecnogo\MeliSdk\Exception\MissingConfigurationException;

/**
 * Class Factory
 *
 * @package Tecnogo\MeliSdk\Client
 */
class Factory
{
    /**
     * @var Config
     */
    private $config;
    /**
     * @var Container
     */
    private $container;
    /**
     * @var CacheFactory
     */
    private $cacheFactory;

    /**
     * Factory constructor.
     *
     * @param Config $config
     * @param array $overrides
     * @throws ContainerException
     * @throws MissingConfigurationException
     */
    public function __construct(Config $config, array $overrides = [])
    {
        $this->config = $config;
        $this->setup($overrides);
        $this->cacheFactory = $this->make(CacheFactory::class);
    }

    /**
     * @param $name
     * @param array $parameters
     * @return mixed
     * @throws ContainerException
     * @throws MissingConfigurationException
     */
    public function make($name, $parameters = [])
    {
        try {
            return $this->container->make($name, $parameters);
        } catch (MissingConfigurationException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new ContainerException($e->getMessage());
        }
    }

    /**
     * @param $class
     * @param $source
     * @return mixed
     * @throws ContainerException
     * @throws MissingConfigurationException
     */
    public function hydrate($class, $source)
    {
        return $this->make($class)->hydrate($source);
    }

    /**
     * @param $class
     * @param $source
     * @return mixed
     * @throws ContainerException
     * @throws MissingConfigurationException
     */
    public function hydrateCollection($class, $source)
    {
        return $this->make($class)->hydrate($source);
    }

    /**
     * @param array $overrides
     */
    protected function setup(array $overrides = [])
    {
        $container = new \Illuminate\Container\Container();
        $definitions = $this->getDefaultDefinitions() + $overrides;

        foreach ($definitions as $abstract => $concrete) {
            $container->bind($abstract, $this->digestSingleDefinition($concrete));
        }

        $this->container = $container;
    }

    /**
     * @return array
     */
    protected function getDefaultDefinitions()
    {
        return [
            Factory::class => $this,
            Config::class => $this->config,
            CacheInterface::class => function () {
                return new FilesystemCache();
            },
            AppId::class => function () {
                return $this->config->getAppId();
            },
            AppSecret::class => function () {
                return $this->config->getAppSecret();
            },
            AccessToken::class => function () {
                return $this->config->getAccessToken();
            },
            SiteId::class => function () {
                return $this->config->getSiteId();
            }
        ];
    }

    /**
     * @param $namespace
     * @return CacheInterface
     * @throws ContainerException
     * @throws MissingConfigurationException
     */
    public function cache($namespace)
    {
        return $this->cacheFactory->get($namespace);
    }

    /**
     * @param $concrete
     * @return \Closure|string
     */
    protected function digestSingleDefinition($concrete)
    {
        if (is_callable($concrete)) {
            $target = function ($container, $parameters) use ($concrete) {
                return $concrete(...array_values($parameters));
            };
        } else if (!is_string($concrete)) {
            $target = function () use ($concrete) {
                return $concrete;
            };
        } else {
            $target = $concrete;
        }
        return $target;
    }
}
