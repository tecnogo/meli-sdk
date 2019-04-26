<?php

namespace Tecnogo\MeliSdk\Entity\Site;

use Tecnogo\MeliSdk\Entity\AbstractEntity;
use Tecnogo\MeliSdk\Entity\Category\Category;
use Tecnogo\MeliSdk\Entity\Currency\Currency;

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
        return \Tecnogo\MeliSdk\Entity\Category\Collection::make($this->get('categories'), function ($category) {
            return $this->client->getFactory()->hydrate(Category::class, $category);
        });
    }

    /**
     * @return \Tecnogo\MeliSdk\Entity\Currency\Collection
     */
    public function currencies()
    {
        return \Tecnogo\MeliSdk\Entity\Currency\Collection::make($this->get('currencies'), function ($currency) {
            return $this->client->getFactory()->hydrate(Currency::class, $currency);
        });
    }
}
