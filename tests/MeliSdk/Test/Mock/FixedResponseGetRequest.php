<?php

namespace Tecnogo\MeliSdk\Test\Mock;

use Tecnogo\MeliSdk\Request\Method;

class FixedResponseGetRequest extends AbstractFixedResponseRequest
{
    /**
     * Get constructor.
     * @param string $resource
     * @param mixed $payload
     * @param array $options
     */
    public function __construct($resource, array $payload = [], array $options = [])
    {
        if (!empty($payload)) {
            $resource = $this->computeResourceUrl($resource, $payload);
        }

        parent::__construct($resource, $payload, $options);
    }

    /**
     * @return string
     * @see Method
     */
    public function getMethod()
    {
        return Method::GET;
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
