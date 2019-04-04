<?php

namespace Tecnogo\MeliSdk\Entity\Category;

use Tecnogo\MeliSdk\Entity\AbstractEntity;
use Tecnogo\MeliSdk\Entity\Category\Api\GetRawCategory;

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
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
     */
    public function id()
    {
        return $this->source['id'] ?? $this->get('id');
    }

    /**
     * @return string|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
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
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
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
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
     */
    public function children()
    {
        return Collection::make(array_map(function ($category) {
            return $this->client->make(Category::class)->hydrate($category);
        }, $this->get('children_categories', [])));
    }

    /**
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
     */
    public function attributes()
    {
        return $this->get();
    }

    /**
     * @return Collection
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
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
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
     */
    public function parent()
    {
        $path = $this->path();

        if ($path->count() === 1) {
            return null;
        }

        return $path->slice(-2, 1)->first();
    }

    /**
     * @param string $path
     * @param null $fallback
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
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
}
