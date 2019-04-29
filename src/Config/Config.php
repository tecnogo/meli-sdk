<?php

namespace Tecnogo\MeliSdk\Config;

use Psr\SimpleCache\CacheInterface;
use Tecnogo\MeliSdk\Cache\CacheStrategy;
use Tecnogo\MeliSdk\Exception\MissingConfigurationException;
use Tecnogo\MeliSdk\Site\Site;

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
     * @var array
     */
    private $options;
    /**
     * @var CacheInterface
     */
    private $sharedCache;

    /**
     * Config constructor.
     * @param array $options
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function __construct(array $options = [])
    {
        $this
            ->setAppId($options['app_id'] ?? null)
            ->setAppSecret($options['app_secret'] ?? null)
            ->setAccessToken($options['access_token'] ?? null)
            ->setSiteId($options['site_id'] ?? Site::MLA)
            ->setRedirectUrl($options['redirect_url'] ?? null)
            ->setApiUrl($options['api_url'] ?? 'https://api.mercadolibre.com/');

        $this->options = $options;
    }

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

    /**
     * @param string $path
     * @param mixed|null $fallback
     * @return array|mixed|null
     */
    protected function get($path, $fallback = null)
    {
        $fragments = explode('.', $path);
        $source = $this->options;

        while (!empty($fragments)) {
            $target = array_shift($fragments);
            if (isset($source[$target])) {
                $source = $source[$target];
            } else {
                return $fallback;
            }
        }

        return $source;
    }

    /**
     * @param string $cacheStrategy
     * @return int
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     */
    public function getCacheStrategyTtl($cacheStrategy)
    {
        CacheStrategy::assert($cacheStrategy);

        return $this->get('cache_ttl.' . strtolower($cacheStrategy)) ??
            $this->getCacheStrategyDefaultTtl($cacheStrategy);
    }

    /**
     * @param string $cacheStrategy
     * @return int
     */
    private function getCacheStrategyDefaultTtl($cacheStrategy)
    {
        return [
            CacheStrategy::BRIEF => 90, // minute and half
            CacheStrategy::LONG => 60 * 60, // 1 hour
            CacheStrategy::DAY => 60 * 60 * 24, // 1 hour
            CacheStrategy::FOREVER => 60 * 60 * 24 * 12 // 1 year
        ][$cacheStrategy];
    }

    /**
     * @return array|mixed|null
     */
    public function cacheDisabled()
    {
        return $this->get('disable_cache');
    }

    /**
     * @param $namespace
     * @return CacheInterface|null
     */
    public function getCache($namespace)
    {
        $caches = $this->get('cache', []);

        return $caches[$namespace] ?? null;
    }
}
