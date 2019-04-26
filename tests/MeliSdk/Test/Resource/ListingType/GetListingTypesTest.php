<?php

namespace Tecnogo\MeliSdk\Test\Resource\ListingType;

use Symfony\Component\Cache\Simple\ArrayCache;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Config\SiteId;
use Tecnogo\MeliSdk\Entity\ListingType\Collection;
use Tecnogo\MeliSdk\Entity\ListingType\ListingType;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;
use Tecnogo\MeliSdk\Test\Resource\CreateCallbackResponseGetRequest;
use Tecnogo\MeliSdk\Test\Resource\CreateMapResponseGetRequest;

class GetListingTypesTest extends AbstractResourceTest
{
    use CreateCallbackResponseGetRequest;
    use CreateMapResponseGetRequest;

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
        $client->listingTypes();
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     */
    public function testGetCurrentSiteListingTypes()
    {
        $response = file_get_contents(__DIR__ . '/Fixture/listing_types.json');
        $currenciesFromFile = json_decode($response);

        $client = $this->getClientWithFixedGetResponse(200, $response);

        $listingTypes = $client->listingTypes();

        $this->assertInstanceOf(Collection::class, $listingTypes);
        $this->assertEquals($listingTypes->count(), count($currenciesFromFile));

        $this->assertInstanceOf(ListingType::class, $listingTypes->first());
        $this->assertCount(7, $listingTypes);
        $this->assertEquals($listingTypes->first()->id(), 'gold_pro');
        $this->assertEquals($listingTypes->first()->name(), 'Premium');
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     */
    public function testGetAnotherSiteListingTypes()
    {
        $response = file_get_contents(__DIR__ . '/Fixture/MLB_listing_types.json');
        $currenciesFromFile = json_decode($response);

        $client = $this->getClientWithMapGetResponse([
            'sites/MLB/listing_types' => [200, $response]
        ], ['disable_cache' => true]);

        $listingTypes = $client->listingTypes(new SiteId('MLB'));

        $this->assertInstanceOf(Collection::class, $listingTypes);
        $this->assertEquals($listingTypes->count(), count($currenciesFromFile));

        $this->assertInstanceOf(ListingType::class, $listingTypes->last());
        $this->assertCount(7, $listingTypes);
        $this->assertEquals($listingTypes->last()->id(), 'free');
        $this->assertEquals($listingTypes->last()->name(), 'Grátis');
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
        $response = file_get_contents(__DIR__ . '/Fixture/listing_types.json');
        $counter = 0;

        $client = $this->getClientWithCallbackGetResponse(function () use ($response, &$counter) {
            $counter++;
            return [200, $response];
        }, ['cache' => ['shared' => new ArrayCache()]]);

        $client->listingTypes();
        $this->assertEquals($counter, 1);
        $client->listingTypes();
        $this->assertEquals($counter, 1);
    }
}
