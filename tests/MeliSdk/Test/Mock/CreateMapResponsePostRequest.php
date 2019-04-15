<?php

namespace Tecnogo\MeliSdk\Test\Mock;

use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Exception\MissingConfigurationException;
use Tecnogo\MeliSdk\Request\Post;

trait CreateMapResponsePostRequest
{
    /**
     * @param $responseMap
     * @param array $options
     * @return Client
     * @throws MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    protected function getClientWithMapPostResponse($responseMap, $options = [])
    {
        return Client::create($options + [
            'definitions' => [
                Post::class => function ($resource, $payload = [], $options = []) use ($responseMap) {
                    $handler = new FixedResponsePostRequest($resource, $payload);

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
