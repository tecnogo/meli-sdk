<?php

namespace Tecnogo\MeliSdk\Test\Mock;

use Tecnogo\MeliSdk\Request\AbstractRequest;

abstract class AbstractFixedResponseRequest extends AbstractRequest
{
    private $callback;

    protected function doRequest($url)
    {
        $callable = $this->callback;

        if (!$callable || !is_callable($callable)) {
            throw new \InvalidArgumentException('Invalid callback');
        }

        return $callable();
    }

    public function setCallback($callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param string $resource
     * @param array $query
     * @return string
     */
    private function computeResourceUrl($resource, array $query = [])
    {
        return $resource . '?' . http_build_query($query);
    }
}
