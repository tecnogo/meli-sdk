<?php

namespace Tecnogo\MeliSdk\Test\Resource\Currency;

use Symfony\Component\Cache\Simple\ArrayCache;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Entity\Currency\Collection;
use Tecnogo\MeliSdk\Entity\Currency\Currency;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;
use Tecnogo\MeliSdk\Test\Resource\CreateCallbackResponseGetRequest;

class GetCurrenciesTest extends AbstractResourceTest
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
        $client->currencies();
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
        $response = file_get_contents(__DIR__ . '/currencies.json');
        $currenciesFromFile = json_decode($response);

        $client = $this->getClientWithFixedGetResponse(200, $response);

        $currencies = $client->currencies();

        $this->assertInstanceOf(Collection::class, $currencies);
        $this->assertEquals($currencies->count(), count($currenciesFromFile));

        $this->assertInstanceOf(Currency::class, $currencies->first());
        $this->assertEquals($currencies->first()->id(), 'ARS');
        $this->assertEquals($currencies->first()->description(), 'Peso argentino');
        $this->assertEquals($currencies->first()->symbol(), '$');
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
        $response = file_get_contents(__DIR__ . '/currencies.json');
        $counter = 0;

        $client = $this->getClientWithCallbackGetResponse(function() use ($response, &$counter) {
            $counter++;
            return [200, $response];
        }, ['cache' => ['shared' => new ArrayCache()]]);

        $client->currencies();
        $this->assertEquals($counter, 1, 'The first call triggers a request');
        $client->currencies();
        $this->assertEquals($counter, 1, 'The second call does not trigger a request');
    }
}
