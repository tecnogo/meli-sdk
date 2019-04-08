<?php

namespace Tecnogo\MeliSdk\Entity\Picture\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetRawPicture
 *
 * @package Tecnogo\MeliSdk\Entity\Picture\Api
 *
 * @internal
 */
final class GetRawPicture extends AbstractTemplateAction
{
    private $id;
    /**
     * @var Factory
     */
    private $factory;

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
        return 'pictures/' . $this->id;
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
