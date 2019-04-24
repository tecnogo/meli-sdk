<?php

namespace Tecnogo\MeliSdk\Test\Resource\Site;

use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Entity\Site\Collection;
use Tecnogo\MeliSdk\Entity\Site\Site;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;
use Tecnogo\MeliSdk\Test\Resource\CreateCallbackResponseGetRequest;
use Tecnogo\MeliSdk\Test\Resource\CreateMapResponseGetRequest;

class GetSitesTest extends AbstractResourceTest
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
        $client->sites();
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
        $response = file_get_contents(__DIR__ . '/Fixture/sites.json');
        $counter = 0;

        $client = $this->getClientWithCallbackGetResponse(function () use ($response, &$counter) {
            $counter++;
            return [200, $response];
        });

        $this->clearCache($client);

        $client->sites();
        $this->assertEquals($counter, 1);
        $client->sites();
        $this->assertEquals($counter, 1);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetSites()
    {
        $client = $this->getClientWithMapGetResponse([
            'sites' => [200, file_get_contents(__DIR__ . '/Fixture/sites.json')]
        ]);

        $sites = $client->sites();

        $this->assertInstanceOf(Collection::class, $sites);
        $this->assertCount(20, $sites);

        $sites->each(function ($site) {
            $this->assertInstanceOf(Site::class, $site);
        });

        $this->assertEquals($sites->first()->id(), 'MRD');
    }

    /**
     * @param Client $client
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    protected function clearCache(Client $client)
    {
        $client
            ->make(\Tecnogo\MeliSdk\Entity\Site\Api\GetSites::class)
            ->cache()
            ->clear();
    }
}
