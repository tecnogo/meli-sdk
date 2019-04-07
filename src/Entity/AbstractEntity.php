<?php

namespace Tecnogo\MeliSdk\Entity;

use Tecnogo\MeliSdk\Client;

/**
 * Class AbstractEntity
 *
 * @package Tecnogo\MeliSdk\Entity
 *
 * @internal
 */
abstract class AbstractEntity implements Entity
{
    /**
     * @var string|int
     */
    protected $id;
    protected $source;
    protected $lazySource;

    /**
     * @var Client
     */
    protected $client;

    /**
     * AbstractEntity constructor.
     *
     * @param Client $client
     * @param array|callable|null $source
     * @param null $id
     */
    public function __construct(Client $client, $source = null, $id = null)
    {
        $this->client = $client;
        $this->id = $id;

        if ($source != null) {
            $this->setSource($source);
        }
    }

    /**
     * @param mixed $source
     * @return $this
     */
    public function hydrate($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return bool
     */
    public function loaded()
    {
        return !!$this->source;
    }

    /**
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->raw(), $options);
    }

    /**
     * @return array
     */
    public function raw()
    {
        $this->lazyLoadIfNeeded();

        return $this->source;
    }

    /**
     * @param string $path
     * @param mixed|null $fallback
     * @return array|mixed|null
     */
    protected function get($path, $fallback = null)
    {
        $fragments = explode('.', $path);
        $source = $this->raw();

        while (!empty($fragments)) {
            $target = array_shift($fragments);
            if (isset($source[$target])) {
                $source = $source[$target];
            } else {
                return $fallback;
            }
        }

        return $source;
    }

    /**
     * @param string $action
     * @return mixed
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    protected function exec($action)
    {
        return $this->client->make($action)->exec();
    }

    private function setSource($source)
    {
        if (is_callable($source)) {
            $this->lazySource = $source;
        } else {
            $this->hydrate($source);
        }

    }

    protected function lazyLoadIfNeeded()
    {
        $callable = $this->lazySource;

        if (!$this->loaded() && is_callable($callable)) {
            $this->hydrate($callable());
        }
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        return $this->client;
    }
}