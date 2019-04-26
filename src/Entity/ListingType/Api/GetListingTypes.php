<?php

namespace Tecnogo\MeliSdk\Entity\ListingType\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Cache\CacheStrategy;
use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Config\SiteId;
use Tecnogo\MeliSdk\Entity\ListingType\Collection;
use Tecnogo\MeliSdk\Entity\ListingType\ListingType;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetListingTypes
 *
 * @package Tecnogo\MeliSdk\Entity\ListingTypes\Api
 */
final class GetListingTypes extends AbstractTemplateAction
{
    /**
     * @var Factory
     */
    private $factory;
    /**
     * @var SiteId
     */
    private $siteId;

    /**
     * GetCurrencies constructor.
     *
     * @param Factory $factory
     * @param SiteId|string $siteId
     */
    public function __construct(Factory $factory, SiteId $siteId)
    {
        $this->factory = $factory;
        $this->siteId = $siteId;
    }

    /**
     * @param array $result
     * @return Collection
     */
    public function handle(array $result = [])
    {
        return Collection::make($result, function ($listingType) {
            return $this->factory->hydrate(ListingType::class, $listingType);
        });
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'sites/' . $this->siteId . '/listing_types';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::GET;
    }

    /**
     * @return string
     */
    public function getCacheStrategy()
    {
        return CacheStrategy::FOREVER;
    }
}
