<?php

namespace Tecnogo\MeliSdk\Entity\Item\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetRawItem
 *
 * @package Tecnogo\MeliSdk\Entity\Item\Api
 *
 * @internal
 */
class GetRawItem extends AbstractTemplateAction
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var Factory
     */
    private $factory;

    /**
     * GetRawItem constructor.
     * @param Factory $factory
     * @param string $id
     */
    public function __construct(Factory $factory, $id)
    {
        $this->id = $id;
        $this->factory = $factory;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'items/' . $this->id;
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
