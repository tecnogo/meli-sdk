<?php

namespace Tecnogo\MeliSdk\Request;

/**
 * Class Delete
 *
 * @package Tecnogo\MeliSdk\Request
 *
 * @internal
 */
final class Delete extends AbstractRequest
{
    public function __construct(string $resource, array $payload = [], array $options = [])
    {
        if (!empty($payload)) {
            $resource = $resource . '?' . http_build_query($payload);
        }

        parent::__construct($resource, $payload, $options);
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            CURLOPT_CUSTOMREQUEST => 'DELETE'
        ];
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::DELETE;
    }
}
