<?php

namespace Tecnogo\MeliSdk\Api;

use Tecnogo\MeliSdk\Config\Config;
use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Request\Delete;
use Tecnogo\MeliSdk\Request\Get;
use Tecnogo\MeliSdk\Request\Method;
use Tecnogo\MeliSdk\Request\Post;

/**
 * Class Facade
 *
 * @package Tecnogo\MeliSdk\Api
 *
 * @internal
 */
final class Facade
{
    const API_URL = 'https://api.mercadolibre.com/';
    const AUTH_URL = 'https://auth.mercadolibre.com.ar/authorization?response_type=code&client_id=';
    const OAUT_URL = 'https://auth.mercadolibre.com.ar/oauth/token';

    /**
     * @var Factory
     */
    private $factory;
    /**
     * @var Config
     */
    private $config;

    public function __construct(Factory $factory, Config $config)
    {
        $this->factory = $factory;
        $this->config = $config;
    }

    /**
     * @param $resource
     * @param array $payload
     * @param array $options
     * @return mixed
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    private function get($resource, array $payload = [], array $options = [])
    {
        return $this->factory
            ->make(Get::class, [
                'resource' => $resource,
                'payload' => $payload,
                'options' => $options
            ])
            ->exec();
    }

    /**
     * @param $resource
     * @param array $payload
     * @param array $options
     * @return mixed
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    private function delete($resource, array $payload = [], array $options = [])
    {
        return $this->factory
            ->make(Delete::class, [
                'resource' => $resource,
                'payload' => $payload,
                'options' => $options
            ])
            ->exec();
    }

    /**
     * @param $resource
     * @param array $payload
     * @param array $options
     * @return mixed
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    private function post($resource, array $payload = [], array $options = [])
    {
        return $this->factory
            ->make(Post::class, [
                'resource' => $resource,
                'payload' => $payload,
                'options' => $options
            ])
            ->exec();
    }

    /**
     * @param Action $action
     * @return mixed
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function exec(Action $action)
    {
        $cacheKey = $action->getMethod() . $action->getResource();
        $cache = $action->cache();

        // We cache only the successful requests
        try {
            if ($cache->has($cacheKey)) {
                $response = $cache->get($cacheKey);
            } else {
                $response = $this->execAction($action);
            }

            $result = $action->handle($response);
            $cache->set($cacheKey, $response);

            return $result;
        } catch (\Exception $e) {
            return $action->handleException($e);
        }
    }

    /**
     * @param Action $action
     * @return mixed
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    private function execAction(Action $action)
    {
        $method = $action->getMethod();
        $resource = $this->config->getApiUrl() . $action->getResource();
        $query = $this->computeQuery($action);

        switch ($method) {
            case Method::GET:
                return $this->get($resource, array_merge($query, $action->getPayload()));
            case Method::POST:
                return $this->post($resource . '?'. http_build_query($query), $action->getPayload());
            case Method::DELETE:
                return $this->delete($resource, array_merge($query, $action->getPayload()));
        }

        throw new \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException($method);
    }

    /**
     * @param Action $action
     * @return array
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    private function computeQuery(Action $action)
    {
        $query = [];
        $config = $this->config;

        if ($action->requiresAccessToken()) {
            $query['access_token'] = $config->getAccessToken()->get();
        }

        if ($action->requiresAppId()) {
            $query['app_id'] = $config->getAppId()->get();
        }

        return $query;
    }
}
