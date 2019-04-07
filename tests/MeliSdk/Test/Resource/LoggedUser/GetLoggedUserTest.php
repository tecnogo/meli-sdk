<?php

namespace Tecnogo\MeliSdk\Test\Resource\LoggedUser;

use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;
use Tecnogo\MeliSdk\Test\Resource\CreateCallbackResponseGetRequest;

class GetLoggedUserTest extends AbstractResourceTest
{
    use CreateCallbackResponseGetRequest;

    /**
     * @param Client $client
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    protected function triggerRequestForErrorResponses(Client $client)
    {
        $client->loggedUser()->raw();
    }

    /**
     * @param $httpCode
     * @param $response
     * @return Client
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    protected function createClientForResponseErrorTest($httpCode, $response)
    {
        return $this->getClientWithFixedGetResponse($httpCode, $response, [
            'app_id' => 'wubba_lubba_dub',
            'access_token' => 'wubba_lubba_dub'
        ]);
    }
}
