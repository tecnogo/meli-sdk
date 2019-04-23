<?php

namespace Tecnogo\MeliSdk\Entity\Picture;

class Variation
{
    /**
     * @var array
     */
    private $source;

    const WIDTH = 0;
    const HEIGHT = 1;

    public function __construct($source = [])
    {
        $this->source = $source;
    }

    /**
     * @return string|null
     */
    public function url()
    {
        return $this->source['url'] ?? null;
    }

    /**
     * @return string|null
     */
    public function secureUrl()
    {
        return $this->source['secure_url'] ?? null;
    }

    /**
     * @return string|null
     */
    public function size()
    {
        return $this->source['size'] ?? null;
    }

    /**
     * @return int|null
     */
    public function width()
    {
        return $this->sizeComponent(static::WIDTH);
    }

    /**
     * @return int|null
     */
    public function height()
    {
        return $this->sizeComponent(static::HEIGHT);
    }

    /**
     * @param $source
     * @param $index
     * @return int|null
     */
    private function sizeComponent($index)
    {
        $size = $this->size();

        if (!$size) {
            return null;
        }

        $fragments = explode('x', $size);

        return (int)$fragments[$index];
    }
}