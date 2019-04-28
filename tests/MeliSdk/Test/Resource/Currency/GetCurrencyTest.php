<?php

namespace Tecnogo\MeliSdk\Test\Resource\Currency;

use Symfony\Component\Cache\Simple\ArrayCache;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Entity\Currency\Currency;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;
use Tecnogo\MeliSdk\Test\Resource\CreateCallbackResponseGetRequest;

class GetCurrencyTest extends AbstractResourceTest
{
    use CreateCallbackResponseGetRequest;

    /**
     * @param Client $client
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     */
    protected function triggerRequestForErrorResponses(Client $client)
    {
        $client->currency('ARS')->raw();
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     */
    public function testGetCurrencies()
    {
        $response = file_get_contents(__DIR__ . '/Fixture/currencies_ARS.json');

        $client = $this->getClientWithFixedGetResponse(200, $response);

        $currency = $client->currency('ARS');

        $this->assertInstanceOf(Currency::class, $currency);

        $this->assertEquals($currency->id(), 'ARS');
        $this->assertEquals($currency->description(), 'Peso argentino');
        $this->assertEquals($currency->symbol(), '$');
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     */
    public function testRequestCache()
    {
        $response = file_get_contents(__DIR__ . '/Fixture/currencies_ARS.json');
        $counter = 0;

        $client = $this->getClientWithCallbackGetResponse(function () use ($response, &$counter) {
            $counter++;
            return [200, $response];
        }, ['cache' => ['shared' => new ArrayCache()]]);

        $client->currency('ARS')->raw();
        $this->assertEquals($counter, 1, 'The first call triggers a request');
        $client->currency('ARS')->raw();
        $this->assertEquals($counter, 1, 'The second call does not trigger a request');
    }
}
