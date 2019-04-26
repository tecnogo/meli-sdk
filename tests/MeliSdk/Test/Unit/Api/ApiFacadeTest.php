<?php

namespace Tecnogo\MeliSdk\Test\Unit\Api;


use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Simple\ArrayCache;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Exception\MissingConfigurationException;
use Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException;
use Tecnogo\MeliSdk\Test\Resource\CreateMapResponseGetRequest;
use Tecnogo\MeliSdk\Test\Unit\Api\Fixture\InvalidHttpMethodAction;
use Tecnogo\MeliSdk\Test\Unit\Api\Fixture\RequiresAppIdMethodAction;
use Tecnogo\MeliSdk\Test\Unit\Api\Fixture\RequiresAccessTokenMethodAction;
use Tecnogo\MeliSdk\Test\Unit\Api\Fixture\VanillaAction;

class ApiFacadeTest extends TestCase
{
    use CreateMapResponseGetRequest;

    /**
     * @throws MissingConfigurationException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function testInvalidHttpMethodThrowsException()
    {
        $client = Client::create();

        $this->expectException(UnknownHttpMethodException::class);

        $client->api()->exec($client->make(InvalidHttpMethodAction::class));
    }

    /**
     * @throws MissingConfigurationException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function testActionRequiringMissingAppIdThrowsException()
    {
        $client = Client::create();

        $this->expectException(MissingConfigurationException::class);
        $this->expectExceptionMessage('Missing configuration: app_id');

        $client->api()->exec($client->make(RequiresAppIdMethodAction::class));
    }

    /**
     * @throws MissingConfigurationException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function testActionRequiringMissingAccessTokenThrowsException()
    {
        $client = Client::create();

        $this->expectException(MissingConfigurationException::class);
        $this->expectExceptionMessage('Missing configuration: access_token');

        $client->api()->exec($client->make(RequiresAccessTokenMethodAction::class));
    }

    /**
     * @throws MissingConfigurationException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetCacheKeyGenerationForPublicActions()
    {
        $cache = new ArrayCache();

        $client  = $this->getClientWithMapGetResponse([
            'vanilla_action' => [200, '[]']
        ], ['cache' => ['shared' => $cache]]);

        $action = $client->make(VanillaAction::class);

        $client->api()->exec($action);

        $this->assertArrayHasKey($action->getCacheKey(), $cache->getValues());
    }

    /**
     * @throws MissingConfigurationException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetCacheKeyGenerationForAppIdActions()
    {
        $cache = new ArrayCache();

        $client  = $this->getClientWithMapGetResponse([
            'requires_app_id' => [200, '[]']
        ], ['app_id' => 'blah', 'cache' => ['shared' => $cache]]);

        $action = $client->make(RequiresAppIdMethodAction::class);

        $client->api()->exec($action);

        $cacheKeys = array_keys($cache->getValues());

        $this->assertCount(1, $cacheKeys);
        $this->assertIsString($cacheKeys[0]);

        $actionKey = substr($cacheKeys[0], 5);

        $this->assertEquals($action->getCacheKey(), $actionKey);
    }

    /**
     * @throws MissingConfigurationException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetCacheKeyGenerationForAccessTokenActions()
    {
        $cache = new ArrayCache();

        $client  = $this->getClientWithMapGetResponse([
            'requires_access_token' => [200, '[]']
        ], ['access_token' => 'blaz', 'cache' => ['shared' => $cache]]);

        $action = $client->make(RequiresAccessTokenMethodAction::class);

        $client->api()->exec($action);

        $cacheKeys = array_keys($cache->getValues());

        $this->assertCount(1, $cacheKeys);
        $this->assertIsString($cacheKeys[0]);
        $actionKey = substr($cacheKeys[0], 5);

        $this->assertEquals($action->getCacheKey(), $actionKey);
    }
}
