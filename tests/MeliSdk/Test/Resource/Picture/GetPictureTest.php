<?php

namespace Tecnogo\MeliSdk\Test\Resource\Picture;

use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;
use Tecnogo\MeliSdk\Test\Resource\CreateCallbackResponseGetRequest;

class GetPictureTest extends AbstractResourceTest
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
        $this->clearCache($client);
        $client->picture('wubba_lubba_dub')->raw();
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testCreationWithIdDoesNotTriggerRequest()
    {
        $client = $this->getClientWithCallbackGetResponse(function () {
            throw new \Exception('request_triggered');
        });

        $item = $client->picture('wubba_lubba_dub');

        $this->assertEquals($item->id(), 'wubba_lubba_dub');

        $this->expectExceptionMessage('request_triggered');
        $item->raw();
    }

    /**
     * @param Client $client
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    protected function clearCache(Client $client)
    {
        $client
            ->make(\Tecnogo\MeliSdk\Entity\Picture\Api\GetRawPicture::class, ['id' => -1])
            ->cache()
            ->clear();
    }
}
