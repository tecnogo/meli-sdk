<?php

namespace Tecnogo\MeliSdk\Test\Resource\Site;

use Symfony\Component\Cache\Simple\ArrayCache;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Entity\Category\Category;
use Tecnogo\MeliSdk\Entity\Category\Collection;
use Tecnogo\MeliSdk\Entity\Currency\Currency;
use Tecnogo\MeliSdk\Entity\ListingType\ListingType;
use Tecnogo\MeliSdk\Entity\ShippingMethod\ShippingMethod;
use Tecnogo\MeliSdk\Site\Site;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;
use Tecnogo\MeliSdk\Test\Resource\CreateCallbackResponseGetRequest;
use Tecnogo\MeliSdk\Test\Resource\CreateMapResponseGetRequest;

class GetSiteTest extends AbstractResourceTest
{
    use CreateCallbackResponseGetRequest;
    use CreateMapResponseGetRequest;

    /**
     * @param Client $client
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    protected function triggerRequestForErrorResponses(Client $client)
    {
        $client->site(Site::MLA)->raw();
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
        $response = file_get_contents(__DIR__ . '/Fixture/site_MLA.json');
        $counter = 0;

        $client = $this->getClientWithCallbackGetResponse(function () use ($response, &$counter) {
            $counter++;
            return [200, $response];
        }, ['cache' => ['shared' => new ArrayCache()]]);

        $this->assertEquals($counter, 0);
        $client->site('MLA')->raw();
        $this->assertEquals($counter, 1, 'The first call triggers a request');
        $client->site('MLA')->raw();
        $this->assertEquals($counter, 1, 'The second call does not trigger a request');
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testLazyLoad()
    {
        $client = $this->getClientWithCallbackGetResponse(function () {
            throw new \Exception('request_triggered');
        }, ['disable_cache' => true]);

        $site = $client->site('MLA');

        $this->assertEquals($site->id(), 'MLA');

        $this->expectExceptionMessage('request_triggered');
        $site->raw();
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetSite()
    {
        $client = $this->getClientWithMapGetResponse([
            'sites/MLA' => [200, file_get_contents(__DIR__ . '/Fixture/site_MLA.json')]
        ], ['cache' => ['shared' => new ArrayCache()]]);

        $site = $client->site('MLA');

        $this->assertInstanceOf(\Tecnogo\MeliSdk\Entity\Site\Site::class, $site);
        $this->assertEquals($site->id(), 'MLA');
        $this->assertEquals($site->name(), 'Argentina');
        $this->assertEquals($site->countryId(), 'AR');
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetSiteCategories()
    {
        $client = $this->getClientWithMapGetResponse([
            'sites/MLA' => [200, file_get_contents(__DIR__ . '/Fixture/site_MLA.json')]
        ], ['cache' => ['shared' => new ArrayCache()]]);

        $site = $client->site('MLA');
        $categories = $site->categories();

        $this->assertInstanceOf(Collection::class, $categories);
        $this->assertCount(30, $categories);
        $this->assertInstanceOf(Category::class, $categories->last());
        $this->assertEquals($categories->first()->id(), 'MLA5725');
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

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetSiteCurrencies()
    {
        $client = $this->getClientWithMapGetResponse([
            'sites/MLA' => [200, file_get_contents(__DIR__ . '/Fixture/site_MLA.json')]
        ], ['cache' => ['shared' => new ArrayCache()]]);

        $site = $client->site('MLA');
        $currencies = $site->currencies();

        $this->assertInstanceOf(\Tecnogo\MeliSdk\Entity\Currency\Collection::class, $currencies);
        $this->assertCount(2, $currencies);
        $this->assertInstanceOf(Currency::class, $currencies->last());
        $this->assertEquals($currencies->first()->id(), 'USD');
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetSitePaymentMethods()
    {
        $client = $this->getClientWithMapGetResponse([
            'sites/MLA/shipping_methods' => [
                200,
                file_get_contents(__DIR__ . '/Fixture/site_MLA_shipping_methods.json')
            ]
        ], ['cache' => ['shared' => new ArrayCache()]]);

        $site = $client->site('MLA');
        $shippingMethods = $site->shippingMethods();

        $this->assertInstanceOf(\Tecnogo\MeliSdk\Entity\ShippingMethod\Collection::class, $shippingMethods);
        $this->assertCount(19, $shippingMethods);
        $this->assertInstanceOf(ShippingMethod::class, $shippingMethods->last());
        $this->assertEquals($shippingMethods->first()->id(), 800);
        $this->assertEquals($shippingMethods->first()->name(), 'Rápido a domicilio');
    }
}
