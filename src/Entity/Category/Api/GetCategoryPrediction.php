<?php

namespace Tecnogo\MeliSdk\Entity\Category\Api;

use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Config\SiteId;
use Tecnogo\MeliSdk\Entity\Category\CategoryPrediction;
use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetCategoryPrediction
 *
 * @package Tecnogo\MeliSdk\Entity\Item\Api
 *
 * @internal
 */
final class GetCategoryPrediction extends AbstractTemplateAction
{
    /**
     * @var string
     */
    private $search;
    /**
     * @var SiteId
     */
    private $siteId;
    /**
     * @var Factory
     */
    private $factory;

    /**
     * GetCategoryPrediction constructor.
     *
     * @param SiteId $siteId
     * @param Factory $factory
     * @param string $search
     */
    public function __construct(SiteId $siteId, Factory $factory, $search = '')
    {
        $this->search = $search;
        $this->siteId = $siteId;
        $this->factory = $factory;
    }

    /**
     * @param array $result
     * @return array
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    public function handle(array $result = [])
    {
        return $this->factory
            ->make(CategoryPrediction::class)
            ->hydrate($result + ['search' => $this->search]);
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'sites/' . $this->siteId . '/category_predictor/predict';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::GET;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return [
            'title' => $this->search
        ];
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
