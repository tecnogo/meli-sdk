<?php

namespace Tecnogo\MeliSdk\Entity\Site\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetSites
 *
 * Sites order IS NOT guaranteed!
 *
 * @package Tecnogo\MeliSdk\Entity\Site\Api
 */
final class GetSites extends AbstractTemplateAction
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * GetCurrencies constructor.
     *
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'sites';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::GET;
    }

    /**
     * @return \Psr\SimpleCache\CacheInterface
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    protected function createCache()
    {
        return $this->factory->cache(static::class);
    }
}
