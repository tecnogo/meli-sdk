<?php

namespace Tecnogo\MeliSdk\Entity\Category;

use Tecnogo\MeliSdk\Entity\AbstractEntity;
use Tecnogo\MeliSdk\Entity\Category\Api\GetRawCategory;
use Tecnogo\MeliSdk\Entity\Category\Api\GetRawCategoryAttributes;
use Tecnogo\MeliSdk\Entity\Category\Attribute\AttributeCollection;
use Tecnogo\MeliSdk\Entity\Category\Attribute\AttributeFactory;

/**
 * Class Category
 *
 * @package Tecnogo\MeliSdk\Entity\Category
 *
 * @internal
 */
final class Category extends AbstractEntity
{
    /**
     * @return string|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     */
    public function id()
    {
        return $this->id ?? $this->get('id');
    }

    /**
     * @return string|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     */
    public function name()
    {
        return $this->source['name'] ?? $this->get('name');
    }

    /**
     * @return string|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     */
    public function permalink()
    {
        return $this->get('permalink');
    }

    /**
     * @return Collection
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     */
    public function children()
    {
        return Collection::make(array_map(function ($category) {
            return $this->client->make(Category::class)->hydrate($category);
        }, $this->get('children_categories', [])));
    }

    /**
     * @return AttributeCollection
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function attributes()
    {
        $rawCategories = $this->client->exec(GetRawCategoryAttributes::class, [
            'categoryId' => $this->id()
        ]);

        return AttributeCollection::make($rawCategories, function ($attribute) {
            return $this->getAttributeFactory()->make($attribute);
        });
    }

    /**
     * @return Collection
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function path()
    {
        return Collection::make(array_map(function ($category) {
            return $this->client->make(Category::class)->hydrate($category);
        }, $this->get('path_from_root', [])));
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     */
    public function parent()
    {
        $path = $this->path();

        if ($path->count() === 1) {
            return null;
        }

        return $path->slice(-2, 1)->first(); // FIXME seems cryptic
    }

    /**
     * @return Settings
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function settings()
    {
        return $this->client->make(Settings::class)->hydrate($this->get('settings', []));
    }

    /**
     * @param string $path
     * @param null $fallback
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    protected function get($path, $fallback = null)
    {
        $this->lazyLoadIfNeeded();

        if (!isset($this->source[$path])) {
            $this->source = $this->client->exec(GetRawCategory::class, [
                'id' => $this->id()
            ]);

            return $this->source[$path] ?? $fallback;
        }

        return parent::get($path, $fallback);
    }

    /**
     * @return AttributeFactory
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    private function getAttributeFactory()
    {
        return $this->client->make(AttributeFactory::class);
    }
}
