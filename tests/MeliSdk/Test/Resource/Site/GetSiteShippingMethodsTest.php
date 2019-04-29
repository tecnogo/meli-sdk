<?php

namespace Tecnogo\MeliSdk\Test\Resource\Site;

use Symfony\Component\Cache\Simple\ArrayCache;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Entity\ShippingMethod\ShippingMethod;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;
use Tecnogo\MeliSdk\Test\Resource\CreateMapResponseGetRequest;

class GetSiteShippingMethodsTest extends AbstractResourceTest
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
        $client->site('MLA')->shippingMethods();
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Cache\Exception\InvalidCacheStrategy
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetSiteShippingMethods()
    {
        $client = $this->getClientWithMapGetResponse([
            'sites/MLA/shipping_methods' => [
                200,
                file_get_contents(__DIR__ . '/Fixture/site_MLA_shipping_methods.json')
            ],
            'sites/MLA/shipping_methods/800' => [
                200,
                file_get_contents(__DIR__ . '/Fixture/site_MLA_shipping_methods_800.json')
            ]
        ], ['cache' => ['shared' => new ArrayCache()]]);

        $site = $client->site('MLA');
        $shippingMethods = $site->shippingMethods();

        $this->assertInstanceOf(\Tecnogo\MeliSdk\Entity\ShippingMethod\Collection::class, $shippingMethods);
        $this->assertCount(19, $shippingMethods);
        $this->assertInstanceOf(ShippingMethod::class, $shippingMethods->last());
        $this->assertEquals($shippingMethods->first()->id(), 800);
        $this->assertEquals($shippingMethods->first()->name(), 'Rápido a domicilio');
        $this->assertEquals($shippingMethods->first()->companyName(), 'Motonorte');
    }
}