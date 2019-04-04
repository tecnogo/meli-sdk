<?php

namespace Tecnogo\MeliSdk\Test\Resource;

use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Request\Get;
use Tecnogo\MeliSdk\Test\Mock\FixedResponseGetRequest;

trait CreateFixedResponseGetRequest
{
    /**
     * @param $httpCode
     * @param $response
     * @return Client
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    protected function getClientWithFixedGetResponse($httpCode, $response = '')
    {
        return new Client([
            'definitions' => [
                Get::class => function ($resource, $payload = [], $options = []) use ($httpCode, $response) {
                    $handler = new FixedResponseGetRequest($resource);
                    $handler->setCallback(function () use ($response, $httpCode) {
                        return [$httpCode, $response];
                    });

                    return $handler;
                }
            ]
        ]);
    }
}
