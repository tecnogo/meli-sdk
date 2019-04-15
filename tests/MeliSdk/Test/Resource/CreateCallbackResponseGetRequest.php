<?php

namespace Tecnogo\MeliSdk\Test\Resource;

use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Exception\MissingConfigurationException;
use Tecnogo\MeliSdk\Request\Get;
use Tecnogo\MeliSdk\Test\Mock\FixedResponseGetRequest;

trait CreateCallbackResponseGetRequest
{
    /**
     * @param $callback
     * @return Client
     * @throws MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    protected function getClientWithCallbackGetResponse($callback, array $options = [])
    {
        return Client::create($options + [
            'definitions' => [
                Get::class => function ($resource, $payload = [], $options = []) use ($callback) {
                    $handler = new FixedResponseGetRequest($resource);
                    $handler->setCallback($callback);

                    return $handler;
                }
            ]
        ]);
    }
}
