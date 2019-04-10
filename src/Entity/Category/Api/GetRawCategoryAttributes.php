<?php

namespace Tecnogo\MeliSdk\Entity\Category\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetRawCategoryAttributes
 *
 * @package Tecnogo\MeliSdk\Entity\Category\Api
 *
 * @internal
 */
final class GetRawCategoryAttributes extends AbstractTemplateAction
{
    /**
     * @var string
     */
    private $categoryId;
    /**
     * @var Factory
     */
    private $factory;

    /**
     * GetRawCategoryAttributes constructor.
     * @param Factory $factory
     * @param string $categoryId
     */
    public function __construct(Factory $factory, $categoryId)
    {
        $this->categoryId = $categoryId;
        $this->factory = $factory;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'categories/' . $this->categoryId . '/attributes';
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
