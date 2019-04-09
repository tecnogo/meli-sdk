<?php

namespace Tecnogo\MeliSdk\Test\Unit\Fixture;

use Tecnogo\MeliSdk\Config\AccessToken;
use Tecnogo\MeliSdk\Config\AppId;
use Tecnogo\MeliSdk\Config\AppSecret;
use Tecnogo\MeliSdk\Config\SiteId;

/**
 * Class ConfigInjected
 *
 * @package Tecnogo\MeliSdk\Test\Fixture
 *
 * @internal
 */
final class ConfigInjected
{
    /**
     * @var SiteId
     */
    public $siteId;
    /**
     * @var AppId
     */
    public $appId;
    /**
     * @var AppSecret
     */
    public $appSecret;
    /**
     * @var AccessToken
     */
    public $accessToken;

    public function __construct(SiteId $siteId, AppId $appId, AppSecret $appSecret, AccessToken $accessToken)
    {
        $this->siteId = $siteId;
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->accessToken = $accessToken;
    }
}
