<?php

namespace Tecnogo\MeliSdk\Entity\Picture;


use Tecnogo\MeliSdk\Entity\AbstractEntity;
use Tecnogo\MeliSdk\Entity\Picture\Api\GetVariations;

/**
 * Class Picture
 *
 * @package Tecnogo\MeliSdk\Entity\Picture
 *
 * @internal
 */
class Picture extends AbstractEntity
{
    /**
     * @return string|null
     */
    public function id()
    {
        return $this->get('id');
    }

    /**
     * @return string|null
     */
    public function url()
    {
        return $this->get('url');
    }

    /**
     * @return string|null
     */
    public function secureUrl()
    {
        return $this->get('secure_url');
    }

    /**
     * @return string|null
     */
    public function size()
    {
        return $this->get('size');
    }

    /**
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function sizes()
    {
        return $this->variations()->sizes();
    }

    /**
     * @return string|null
     */
    public function maxSize()
    {
        return $this->get('max_size');
    }

    /**
     * @return string|null
     */
    public function quality()
    {
        return $this->get('quality');
    }

    /**
     * @return int|null
     */
    public function width()
    {
        return $this->sizeComponent('size', 0);
    }

    /**
     * @return int|null
     */
    public function height()
    {
        return $this->sizeComponent('size', 1);
    }

    /**
     * @return bool
     */
    public function isMaxSize()
    {
        $size = $this->get('size');

        return $size && $size === $this->maxSize();
    }

    /**
     * @return VariationCollection
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function variations()
    {
        $id = $this->id();

        if (!$id) {
            return VariationCollection::make();
        }

        return $this->client->exec(GetVariations::class, ['id' => $id]);
    }

    /**
     * @param $source
     * @param $index
     * @return int|null
     */
    private function sizeComponent($source, $index)
    {
        $size = $this->get($source);

        if (!$size) {
            return null;
        }

        $fragments = explode('x', $size);

        return (int)$fragments[$index];
    }
}
