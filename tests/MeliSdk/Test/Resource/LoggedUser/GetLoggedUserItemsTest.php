<?php

namespace Tecnogo\MeliSdk\Test\Resource\LoggedUser;

use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;

class GetLoggedUserItemsTest extends AbstractResourceTest
{
    /**
     * @param Client $client
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    protected function triggerRequestForErrorResponses(Client $client)
    {
        $client
            ->getConfig()
            ->setAccessToken('APP_USR-1234567890123456-123456-c89d1876c5b14a6b43ac2e816c2b04d2-1234567');

        $client->loggedUser()->items()->get();
    }
}
