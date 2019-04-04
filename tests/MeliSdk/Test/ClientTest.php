<?php

namespace Tecnogo\MeliSdk\Test;

use PHPUnit\Framework\TestCase;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Site\Site;

class ClientTest extends TestCase
{
    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testClientCreationWithoutParameters()
    {
        $this->assertInstanceOf(Client::class, new Client());
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testClientCreationWithInvalidSiteId()
    {
        $this->expectException(\Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException::class);

        new Client([
            'site_id' => 'MLNZ'
        ]);
    }

    /**
     * @param $siteId
     * @dataProvider siteIdDataProvider
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    public function testClientValidSiteId($siteId)
    {
        $client = new Client([
            'site_id' => $siteId
        ]);

        $this->assertEquals($siteId, $client->getConfig()->getSiteId());
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function siteIdDataProvider()
    {
        return array_map(function($siteId) {
            return [$siteId];
        }, Site::all());
    }
}