<?php

namespace Tecnogo\MeliSdk\Entity\Category\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Config\SiteId;
use Tecnogo\MeliSdk\Entity\Category\Category;
use Tecnogo\MeliSdk\Entity\Category\Collection;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetCategories
 *
 * @package Tecnogo\MeliSdk\Entity\Category\Api
 *
 * @internal
 */
final class GetCategories extends AbstractTemplateAction
{
    /**
     * @var SiteId
     */
    private $siteId;
    /**
     * @var Factory
     */
    private $factory;

    /**
     * GetCategories constructor.
     *
     * @param SiteId $siteId
     * @param Factory $factory
     */
    public function __construct(SiteId $siteId, Factory $factory)
    {
        $this->siteId = $siteId;
        $this->factory = $factory;
    }

    /**
     * @param array $result
     * @return Collection
     */
    public function handle(array $result = [])
    {
        return Collection::make($result, function ($category) {
            return $this->factory->hydrate(Category::class, $category);
        });
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'sites/' . $this->siteId . '/categories';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::GET;
    }
}
