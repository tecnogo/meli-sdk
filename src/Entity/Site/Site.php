<?php

namespace Tecnogo\MeliSdk\Entity\Site;

use Tecnogo\MeliSdk\Entity\AbstractEntity;
use Tecnogo\MeliSdk\Entity\Category\Category;
use Tecnogo\MeliSdk\Entity\Currency\Currency;
use Tecnogo\MeliSdk\Entity\PaymentMethod\Api\GetSitePaymentMethods;
use Tecnogo\MeliSdk\Entity\PaymentMethod\PaymentMethod;
use Tecnogo\MeliSdk\Entity\ShippingMethod\Api\GetSiteShippingMethods;
use Tecnogo\MeliSdk\Entity\ShippingMethod\ShippingMethod;
use Tecnogo\MeliSdk\Entity\Site\Api\GuessSiteUrl;
use Tecnogo\MeliSdk\Request\Exception\NotFoundException;
use Tecnogo\MeliSdk\Request\Exception\RequestErrorException;

/**
 * Class Site
 *
 * @package Tecnogo\MeliSdk\Entity\Site
 */
final class Site extends AbstractEntity
{
    /**
     * @return string|null
     */
    public function id()
    {
        return $this->id ?? $this->get('id');
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->get('name');
    }

    /**
     * @return string
     */
    public function countryId()
    {
        return $this->get('country_id');
    }

    /**
     * @return \Tecnogo\MeliSdk\Entity\Category\Collection
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function categories()
    {
        return \Tecnogo\MeliSdk\Entity\Category\Collection::make(
            $this->get('categories', []),
            function ($category) {
                return $this->client->getFactory()->hydrate(Category::class, $category);
            }
        );
    }

    /**
     * @return \Tecnogo\MeliSdk\Entity\Currency\Collection
     */
    public function currencies()
    {
        return \Tecnogo\MeliSdk\Entity\Currency\Collection::make(
            $this->get('currencies', []),
            function ($currency) {
                return $this->client->getFactory()->hydrate(Currency::class, $currency);
            }
        );
    }

    /**
     * @return \Tecnogo\MeliSdk\Entity\ShippingMethod\Collection
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function shippingMethods()
    {
        $rawShippingMethods = $this->client->exec(GetSiteShippingMethods::class, ['siteId' => $this->id()]);

        return \Tecnogo\MeliSdk\Entity\ShippingMethod\Collection::make($rawShippingMethods, function ($shippingMethod) {
            return $this->client->make(ShippingMethod::class)->hydrate($shippingMethod);
        });
    }

    /**
     * @return \Tecnogo\MeliSdk\Entity\PaymentMethod\Collection
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function paymentMethods()
    {
        $rawPaymentMethods = $this->client->exec(GetSitePaymentMethods::class, ['siteId' => $this->id()]);

        return \Tecnogo\MeliSdk\Entity\PaymentMethod\Collection::make($rawPaymentMethods, function ($paymentMethod) {
            return $this->client->make(PaymentMethod::class)->hydrate($paymentMethod);
        });
    }

    /**
     * @return \Tecnogo\MeliSdk\Entity\ListingType\Collection
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function listingTypes()
    {
        return $this->client->listingTypes($this->id());
    }

    /**
     * @return Settings
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    public function settings()
    {
        return $this->client->make(Settings::class)->hydrate($this->get('settings'));
    }

    /**
     * @return string
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function url()
    {
        try {
            return $this->client->exec(GuessSiteUrl::class, ['site' => $this]);
        } catch (NotFoundException $e) {
            return null;
        }
    }
}
