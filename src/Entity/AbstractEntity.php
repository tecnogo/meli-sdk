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
    protected $sources = [];

    /**
     * @var Client
     */
    protected $client;

    /**
     * AbstractEntity constructor.
     *
     * @param Client $client
     * @param array $sources
     */
    public function __construct(Client $client, $sources = [])
    {
        $this->client = $client;
        $this->sources = $sources;
    }

    /**
     * @param mixed $source
     * @return $this
     */
    public function hydrate($source)
    {
        $this->sources[] = $source;

        return $this;
    }

    /**
     * @return bool
     */
    public function loaded()
    {
        foreach ($this->sources as $source) {
            if (is_callable($source)) {
                return false;
            }
        };

        return true;
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

        return count($this->sources) ? array_merge(...$this->sources) : [];
    }

    /**
     * @param string $path
     * @param mixed|null $fallback
     * @return array|mixed|null
     */
    protected function get($path, $fallback = null)
    {
        foreach ($this->sources as $source) {
            $result = $this->findInSource($source, $path);

            if ($result !== null) {
                return $result;
            }
        }

        if (!$this->loaded()) {
            $this->lazyLoadIfNeeded();
            return $this->get($path, $fallback);
        }

        return $fallback;
    }

    /**
     * @param array|callable $source
     * @param string $path
     * @return mixed|null
     */
    private function findInSource($source, $path)
    {
        $fragments = explode('.', $path);

        if (is_callable($source)) {
            return null;
        }

        if (is_array($source)) {
            while (!empty($fragments)) {
                $target = array_shift($fragments);
                if (isset($source[$target])) {
                    $source = $source[$target];
                } else {
                    return null;
                }
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

    /**
     * Load all pending sources
     */
    protected function lazyLoadIfNeeded()
    {
        foreach ($this->sources as $index => $source) {
            if (is_callable($source)) {
                $this->sources[$index] = $source();
            }
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
