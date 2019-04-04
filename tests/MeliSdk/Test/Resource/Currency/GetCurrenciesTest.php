<?php

namespace Tecnogo\MeliSdk\Test\Resource\Currency;

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
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
     */
    protected function triggerRequestForErrorResponses(Client $client)
    {
        $this->clearCache($client);
        $client->currencies();
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetCurrencies()
    {
        $response = file_get_contents(__DIR__ . '/currencies.json');
        $currenciesFromFile = json_decode($response);

        $client = $this->getClientWithFixedGetResponse(200, $response);
        $this->clearCache($client);

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
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testRequestCache()
    {
        $response = file_get_contents(__DIR__ . '/currencies.json');
        $counter = 0;

        $client = $this->getClientWithCallbackGetResponse(function() use ($response, &$counter) {
            $counter++;
            return [200, $response];
        });

        $this->clearCache($client);

        $client->currencies();
        $this->assertEquals($counter, 1);
        $client->currencies();
        $this->assertEquals($counter, 1);
    }

    /**
     * @param Client $client
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    protected function clearCache(Client $client): void
    {
        $client
            ->make(\Tecnogo\MeliSdk\Entity\Currency\Api\GetCurrencies::class)
            ->cache()
            ->clear();
    }
}
