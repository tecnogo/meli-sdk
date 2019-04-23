<?php

namespace Tecnogo\MeliSdk\Test\Resource\ListingType;

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
     */
    protected function triggerRequestForErrorResponses(Client $client)
    {
        $this->clearCache($client);
        $client->listingTypes();
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetCurrentSiteListingTypes()
    {
        $response = file_get_contents(__DIR__ . '/Fixture/listing_types.json');
        $currenciesFromFile = json_decode($response);

        $client = $this->getClientWithFixedGetResponse(200, $response);
        $this->clearCache($client);

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
     */
    public function testGetAnotherSiteListingTypes()
    {
        $response = file_get_contents(__DIR__ . '/Fixture/MLB_listing_types.json');
        $currenciesFromFile = json_decode($response);

        $client = $this->getClientWithMapGetResponse([
            'sites/MLB/listing_types' => [200, $response]
        ]);

        $this->clearCache($client);

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
     */
    public function testRequestCache()
    {
        $response = file_get_contents(__DIR__ . '/Fixture/listing_types.json');
        $counter = 0;

        $client = $this->getClientWithCallbackGetResponse(function() use ($response, &$counter) {
            $counter++;
            return [200, $response];
        });

        $this->clearCache($client);

        $client->listingTypes();
        $this->assertEquals($counter, 1);
        $client->listingTypes();
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
            ->make(\Tecnogo\MeliSdk\Entity\ListingType\Api\GetListingTypes::class)
            ->cache()
            ->clear();
    }
}
