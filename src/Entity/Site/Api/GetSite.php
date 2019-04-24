<?php

namespace Tecnogo\MeliSdk\Entity\Site\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Config\SiteId;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetSite
 *
 * @package Tecnogo\MeliSdk\Entity\Site\Api
 */
final class GetSite extends AbstractTemplateAction
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var Factory
     */
    private $factory;

    public function __construct($id, Factory $factory)
    {
        $this->id = $id;
        $this->factory = $factory;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'sites/' . $this->id;
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
