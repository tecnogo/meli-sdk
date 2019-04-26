<?php

namespace Tecnogo\MeliSdk\Test\Api;


use PHPUnit\Framework\TestCase;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Exception\MissingConfigurationException;
use Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException;
use Tecnogo\MeliSdk\Test\Api\Fixture\InvalidHttpMethodAction;
use Tecnogo\MeliSdk\Test\Api\Fixture\RequiresAppIdMethodAction;
use Tecnogo\MeliSdk\Test\Api\Fixture\RequiresAccessTokenMethodAction;

class ApiFacadeTest extends TestCase
{
    /**
     * @throws MissingConfigurationException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
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
     */
    public function testActionRequiringMissingAccessTokenThrowsException()
    {
        $client = Client::create();

        $this->expectException(MissingConfigurationException::class);
        $this->expectExceptionMessage('Missing configuration: access_token');

        $client->api()->exec($client->make(RequiresAccessTokenMethodAction::class));
    }
}
