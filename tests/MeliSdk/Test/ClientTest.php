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
        $this->assertInstanceOf(Client::class, Client::create());
    }
}