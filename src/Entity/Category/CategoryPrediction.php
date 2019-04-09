<?php

namespace Tecnogo\MeliSdk\Entity\Category;

use Tecnogo\MeliSdk\Entity\AbstractEntity;

/**
 * Class CategoryPrediction
 *
 * @package Tecnogo\MeliSdk\Entity\Category
 *
 * @internal
 */
class CategoryPrediction extends AbstractEntity
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
    public function search()
    {
        return $this->get('search');
    }

    /**
     * @return string|null
     */
    public function name()
    {
        return $this->get('name');
    }

    /**
     * @return CategoryPredictionPath
     */
    public function path()
    {
        return CategoryPredictionPath
            ::make($this->get('path_from_root'), function ($raw) {
                return (new static($this->client))
                    ->hydrate($raw + ['search' => $this->search()]);
            });
    }

    /**
     * @return CategoryPrediction|null
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
     * @return float|null
     */
    public function predictionProbability()
    {
        return $this->get('prediction_probability');
    }

    /**
     * @return Category
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function category()
    {
        return $this->getClient()->category($this->id());
    }
}
