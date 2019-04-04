<?php

namespace Tecnogo\MeliSdk\Auth;

use Tecnogo\MeliSdk\Auth\Exception\InvalidAuthException;
use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Config\AccessToken;
use Tecnogo\MeliSdk\Config\Config;
use Tecnogo\MeliSdk\Exception\MissingConfigurationException;
use Tecnogo\MeliSdk\Request\Exception\RequestErrorException;
use Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException;
use Tecnogo\MeliSdk\Site\SiteUrl;

/**
 * Class Facade
 *
 * @package Tecnogo\MeliSdk\Auth
 */
final class Facade
{
    /**
     * @var Config
     */
    private $config;
    /**
     * @var Factory
     */
    private $factory;

    public function __construct(Config $config, Factory $factory)
    {
        $this->config = $config;
        $this->factory = $factory;
    }

    /**
     * @return mixed
     * @throws MissingConfigurationException
     * @throws InvalidSiteIdException
     */
    public function getAuthUrl()
    {
        return SiteUrl::getRegionAuthUrl($this->config->getSiteId()) . '?' . http_build_query([
                'response_type' => 'code',
                'client_id' => $this->config->getAppId()->__toString()
            ]);
    }

    /**
     * @param $code
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws MissingConfigurationException
     * @throws InvalidAuthException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     */
    public function login($code)
    {
        $request = new PostCodeRequest($code, $this->config, $this->factory);

        try {
            $result = $request->exec();
        } catch (RequestErrorException $e) {
            throw new InvalidAuthException($e->getMessage());
        }

        if (!isset($result['access_token'])) {
            throw new InvalidAuthException('incomplete_data');
        }

        $this->config->setAccessToken($result);
    }
}
