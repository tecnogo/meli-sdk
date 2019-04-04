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
