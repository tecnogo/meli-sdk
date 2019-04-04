<?php

namespace Tecnogo\MeliSdk\Auth;

use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Config\Config;
use Tecnogo\MeliSdk\Request\Method;
use Tecnogo\MeliSdk\Request\Post;
use Tecnogo\MeliSdk\Request\Request;

/**
 * Class PostCodeRequest
 *
 * @package Tecnogo\MeliSdk\Auth
 *
 * @internal
 */
final class PostCodeRequest implements Request
{
    /**
     * @var Request
     */
    private $request;

    /**
     * PostLoginRequest constructor.
     * @param $code
     * @param Config $config
     * @param Factory $factory
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    public function __construct($code, Config $config, Factory $factory)
    {
        $this->request = $factory->make(Post::class, [
            'resource' => $config->getApiUrl() . 'oauth/token',
            'payload' => [
                'code' => $code,
                'grant_type' => 'authorization_code',
                'client_id' => $config->getAppId()->get(),
                'client_secret' => $config->getAppSecret()->get(),
                'redirect_uri' => $config->getRedirectUrl()->get()
            ]
        ]);
    }

    /**
     * @return mixed
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function exec()
    {
        return $this->request->exec();
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->request->getPayload();
    }

    /**
     * @return string
     * @see Method
     */
    public function getMethod()
    {
        return Method::POST;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->request->__toString();
    }
}
