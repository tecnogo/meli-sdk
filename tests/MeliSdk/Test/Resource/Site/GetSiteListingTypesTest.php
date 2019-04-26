<?php

namespace Tecnogo\MeliSdk\Test\Resource\Site;

use Symfony\Component\Cache\Simple\ArrayCache;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Entity\ListingType\ListingType;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;
use Tecnogo\MeliSdk\Test\Resource\CreateMapResponseGetRequest;

class GetSiteListingTypesTest extends AbstractResourceTest
{
    use CreateMapResponseGetRequest;

    /**
     * @param Client $client
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    protected function triggerRequestForErrorResponses(Client $client)
    {
        $client->site('MLA')->listingTypes();
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     */
    public function testGetSiteListingTypes()
    {
        $client = $this->getClientWithMapGetResponse([
            'sites/MLA/listing_types' => [200, file_get_contents(__DIR__ . '/Fixture/sites_MLA_listing_types.json')]
        ], ['cache' => ['shared' => new ArrayCache()]]);

        $site = $client->site('MLA');
        $listingTypes = $site->listingTypes();

        $this->assertInstanceOf(\Tecnogo\MeliSdk\Entity\ListingType\Collection::class, $listingTypes);
        $this->assertCount(7, $listingTypes);
        $this->assertInstanceOf(ListingType::class, $listingTypes->last());
        $this->assertEquals($listingTypes->first()->id(), 'gold_pro');
    }
}
