<?php

namespace Tecnogo\MeliSdk\Test;

use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Config\AccessToken;
use Tecnogo\MeliSdk\Config\AppId;
use Tecnogo\MeliSdk\Config\AppSecret;
use Tecnogo\MeliSdk\Config\SiteId;
use Tecnogo\MeliSdk\Exception\MissingConfigurationException;
use Tecnogo\MeliSdk\Test\Fixture\AppIdInjected;
use Tecnogo\MeliSdk\Test\Fixture\AppSecretInjected;
use Tecnogo\MeliSdk\Test\Fixture\ConfigInjected;
use PHPUnit\Framework\TestCase;
use Tecnogo\MeliSdk\Site\Site;
use Tecnogo\MeliSdk\Test\Fixture\EmptyClassA;
use Tecnogo\MeliSdk\Test\Fixture\EmptyClassB;

class FactoryTest extends TestCase
{
    /**
     * @throws MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testConfigInjection()
    {
        $appId = 'app_id';
        $appSecret = 'app_secret';
        $siteId = Site::MPT;
        $accessToken = sha1(rand(0, 1000));

        $client = new Client([
            'app_id' => $appId,
            'app_secret' => $appSecret,
            'site_id' => $siteId,
            'access_token' => $accessToken
        ]);

        $factory = $client->getFactory();

        $injectedClass = $factory->make(ConfigInjected::class);

        $this->assertInstanceOf(AppId::class, $injectedClass->appId);
        $this->assertEquals($injectedClass->appId, $appId);

        $this->assertInstanceOf(AppSecret::class, $injectedClass->appSecret);
        $this->assertEquals($injectedClass->appSecret, $appSecret);

        $this->assertInstanceOf(SiteId::class, $injectedClass->siteId);
        $this->assertEquals($injectedClass->siteId, $siteId);

        $this->assertInstanceOf(AccessToken::class, $injectedClass->accessToken);
        $this->assertEquals($injectedClass->accessToken, $accessToken);
    }

    /**
     * @throws MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testMissingAppIdConfigInjection()
    {
        $client = new Client();
        $factory = $client->getFactory();

        $this->expectException(MissingConfigurationException::class);
        $this->expectExceptionMessage('Missing configuration: app_id');

        $factory->make(AppIdInjected::class);
    }

    /**
     * @throws MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testMissingAppSecretConfigInjection()
    {
        $client = new Client();
        $factory = $client->getFactory();

        $this->expectException(MissingConfigurationException::class);
        $this->expectExceptionMessage('Missing configuration: app_secret');

        $factory->make(AppSecretInjected::class);
    }

    /**
     * @throws MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testOverridingDefinitions()
    {
        $client = new Client([
            'definitions' => [
                EmptyClassA::class => EmptyClassB::class
            ]
        ]);

        $factory = $client->getFactory();

        $this->assertInstanceOf(EmptyClassB::class, $factory->make(EmptyClassA::class));
    }
}