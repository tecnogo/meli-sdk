<?php

namespace Tecnogo\MeliSdk\Entity\Item;

use Tecnogo\MeliSdk\Entity\AbstractEntity;
use Tecnogo\MeliSdk\Entity\Picture\Picture;

/**
 * Class Item
 *
 * @package Tecnogo\MeliSdk\Item
 *
 * @internal
 */
final class Item extends AbstractEntity
{
    /**
     * @var AttributeCollection
     */
    private $attributeCollection;

    /**
     * @var \Tecnogo\MeliSdk\Entity\Picture\Collection
     */
    private $pictureCollection;

    /**
     * @return string|null
     */
    public function id()
    {
        return $this->id ?? $this->get('id');
    }

    /**
     * @return string|null
     */
    public function permalink()
    {
        return $this->get('permalink');
    }

    /**
     * @return string|null
     */
    public function title()
    {
        return $this->get('title');
    }

    /**
     * @return string|null
     */
    public function description()
    {
        return $this->get('description');
    }

    /**
     * @return string|null
     */
    public function thumbnail()
    {
        return $this->get('thumbnail');
    }

    /**
     * @return string|null
     */
    public function secureThumbnail()
    {
        return $this->get('secure_thumbnail');
    }

    /**
     * @return float
     */
    public function price()
    {
        return $this->get('price');
    }

    /**
     * @return string|null
     */
    public function createdAt()
    {
        return $this->get('date_created');
    }

    /**
     * @return string|null
     */
    public function updatedAt()
    {
        return $this->get('last_updated');
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        return $this;
    }

    /**
     * @return \Tecnogo\MeliSdk\Entity\Category\Category
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
    public function category()
    {
        return $this->client->category($this->get('category_id'));
    }

    /**
     * @return AttributeCollection
     */
    public function attributes()
    {
        if (!$this->attributeCollection) {
            $this->attributeCollection = AttributeCollection::make(array_map(function ($picture) {
                return $this->client->make(Attribute::class)->hydrate($picture);
            }, $this->get('attributes')));
        }

        return $this->attributeCollection;
    }

    /**
     * @return \Tecnogo\MeliSdk\Entity\Picture\Collection|Collection
     */
    public function pictures()
    {
        if (!$this->pictureCollection) {
            $this->pictureCollection = \Tecnogo\MeliSdk\Entity\Picture\Collection::make(array_map(function ($picture) {
                return $this->client->make(Picture::class)->hydrate($picture);
            }, $this->get('pictures')));
        }

        return $this->pictureCollection;
    }
}
