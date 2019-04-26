<?php

namespace Tecnogo\MeliSdk\Test\Resource\Site;

use Symfony\Component\Cache\Simple\ArrayCache;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Entity\PaymentMethod\PaymentMethod;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;
use Tecnogo\MeliSdk\Test\Resource\CreateMapResponseGetRequest;

class GetSitePaymentMethodsTest extends AbstractResourceTest
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
        $client->site('MLA')->paymentMethods();
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
            'sites/MLA/payment_methods' => [
                200,
                file_get_contents(__DIR__ . '/Fixture/site_MLA_payment_methods.json')
            ]
        ], ['cache' => ['shared' => new ArrayCache()]]);

        $site = $client->site('MLA');
        $paymentMethods = $site->paymentMethods();

        $this->assertInstanceOf(\Tecnogo\MeliSdk\Entity\PaymentMethod\Collection::class, $paymentMethods);
        $this->assertCount(24, $paymentMethods);
        $this->assertInstanceOf(PaymentMethod::class, $paymentMethods->last());
        $this->assertEquals($paymentMethods->first()->id(), 'visa');
        $this->assertEquals($paymentMethods->first()->name(), 'Visa');
    }
}