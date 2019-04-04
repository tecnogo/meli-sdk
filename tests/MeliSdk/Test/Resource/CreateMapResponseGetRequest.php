<?php

namespace Tecnogo\MeliSdk\Test\Resource;

use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Exception\MissingConfigurationException;
use Tecnogo\MeliSdk\Request\Get;
use Tecnogo\MeliSdk\Test\Mock\FixedResponseGetRequest;

trait CreateMapResponseGetRequest
{
    /**
     * @param $responseMap
     * @return Client
     * @throws MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    protected function getClientWithMapGetResponse($responseMap)
    {
        return new Client([
            'definitions' => [
                Get::class => function ($resource, $payload = [], $options = []) use ($responseMap) {
                    $handler = new FixedResponseGetRequest($resource, $payload);

                    $resource = $handler->getResource();

                    $handler->setCallback(function () use ($responseMap, $resource) {
                        $response = null;

                        foreach ($responseMap as $key => $value) {
                            if (strpos($resource, $key)) {
                                $response = $value;
                                break;
                            }
                        }

                        if (!$response) {
                            throw new \InvalidArgumentException('Required response not found: ' . $resource);
                        }

                        return $response;
                    });

                    return $handler;
                }
            ]
        ]);
    }
}
