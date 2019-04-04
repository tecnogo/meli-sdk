<?php

namespace Tecnogo\MeliSdk\Config;

use Tecnogo\MeliSdk\Exception\MissingConfigurationException;

/**
 * Class Client
 *
 * @package MeliSdk\Client
 *
 * @internal
 */
final class Config
{
    /**
     * @var AppId
     */
    private $appId;
    /**
     * @var AppSecret
     */
    private $appSecret;
    /**
     * @var SiteId
     */
    private $siteId;
    /**
     * @var AccessToken
     */
    private $accessToken;
    /**
     * @var RedirectUrl
     */
    private $redirectUrl;
    /**
     * @var ApiUrl
     */
    private $apiUrl;

    /**
     * @return AppId
     * @throws MissingConfigurationException
     */
    public function getAppId()
    {
        $appId = $this->appId;

        if (!$appId || $appId->isEmpty()) {
            throw new MissingConfigurationException('Missing configuration: app_id');
        }

        return $appId;
    }

    /**
     * @return AppSecret
     * @throws MissingConfigurationException
     */
    public function getAppSecret()
    {
        $appSecret = $this->appSecret;

        if (!$appSecret || $appSecret->isEmpty()) {
            throw new MissingConfigurationException('Missing configuration: app_secret');
        }

        return $appSecret;
    }

    /**
     * @return SiteId
     * @throws MissingConfigurationException
     */
    public function getSiteId()
    {
        $siteId = $this->siteId;

        if (!$siteId) {
            throw new MissingConfigurationException('Missing configuration: site_id');
        }

        return $siteId;
    }

    /**
     * @return AccessToken
     * @throws MissingConfigurationException
     */
    public function getAccessToken()
    {
        $accessToken = $this->accessToken;

        if (!$accessToken || $accessToken->isEmpty()) {
            throw new MissingConfigurationException('Missing configuration: access_token');
        }

        return $accessToken;
    }

    /**
     * @return RedirectUrl
     * @throws MissingConfigurationException
     */
    public function getRedirectUrl()
    {
        $redirectUrl = $this->redirectUrl;

        if (!$redirectUrl || $redirectUrl->isEmpty()) {
            throw new MissingConfigurationException('Missing configuration: redirect_url');
        }

        return $this->redirectUrl;
    }

    /**
     * @return ApiUrl
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @param string $appId
     * @return Config
     */
    public function setAppId($appId)
    {
        $this->appId = new AppId($appId);

        return $this;
    }

    /**
     * @param string $appSecret
     * @return Config
     */
    public function setAppSecret($appSecret)
    {
        $this->appSecret = new AppSecret($appSecret);

        return $this;
    }

    /**
     * @param string $siteId
     * @return Config
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function setSiteId($siteId)
    {
        $this->siteId = new SiteId($siteId);

        return $this;
    }

    /**
     * @param string|null $token
     * @return Config
     */
    public function setAccessToken($token)
    {
        $this->accessToken = AccessToken::from($token);
        return $this;
    }

    /**
     * @param string|null $redirectUrl
     * @return Config
     */
    public function setRedirectUrl($redirectUrl = '')
    {
        $this->redirectUrl = new RedirectUrl($redirectUrl);

        return $this;
    }

    /**
     * @param string|null $apiUrl
     * @return Config
     */
    public function setApiUrl($apiUrl = '')
    {
        $this->apiUrl = new ApiUrl($apiUrl);

        return $this;
    }
}
