<?php

namespace Tecnogo\MeliSdk\Request;

/**
 * Class Post
 *
 * @package Tecnogo\MeliSdk\Request
 *
 * @internal
 */
final class Post extends AbstractRequest
{
    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::POST;
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return parent::getOptions() + [
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($this->getPayload())
        ];
    }
}
