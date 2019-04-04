<?php

namespace Tecnogo\MeliSdk\Test\Auth;

use PHPUnit\Framework\TestCase;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Exception\MissingConfigurationException;
use Tecnogo\MeliSdk\Site\Site;

class ClientGetAutRedirectUrlTest extends TestCase
{
    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testDefaultConfiguration()
    {
        $client = new Client();

        $this->expectException(MissingConfigurationException::class);
        $this->expectExceptionMessage('Missing configuration: app_id');

        $client->getAuthUrl();
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testDefaultConfigurationWithAppIdAndRedirectUrl()
    {
        $client = new Client([
            'app_id' => 'wubba_lubba_dub',
            'redirect_url' => 'https://www.example.com/meli'
        ]);

        $redirectUrl = $client->getAuthUrl();

        $this->assertIsString($redirectUrl);
        $this->assertEquals(
            $redirectUrl,
            'https://auth.mercadolibre.com.ar/authorization?response_type=code&client_id=wubba_lubba_dub'
        );
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testConfigWithSiteId()
    {
        $client = new Client([
            'site_id' => Site::MCO,
            'app_id' => 'wubba_lubba_dub',
            'redirect_url' => 'https://www.example.com/meli'
        ]);

        $redirectUrl = $client->getAuthUrl();

        $this->assertIsString($redirectUrl);
        $this->assertEquals(
            $redirectUrl,
            'https://auth.mercadolibre.com.co/authorization?response_type=code&client_id=wubba_lubba_dub'
        );
    }
}
