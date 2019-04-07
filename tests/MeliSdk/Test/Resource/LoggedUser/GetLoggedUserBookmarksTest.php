<?php

namespace Tecnogo\MeliSdk\Test\Resource\LoggedUser;

use function foo\func;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Entity\Item\Item;
use Tecnogo\MeliSdk\Entity\LoggedUser\Bookmark;
use Tecnogo\MeliSdk\Entity\LoggedUser\BookmarkCollection;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;
use Tecnogo\MeliSdk\Test\Resource\CreateCallbackResponseGetRequest;
use Tecnogo\MeliSdk\Test\Resource\CreateMapResponseGetRequest;

class GetLoggedUserBookmarksTest extends AbstractResourceTest
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
        $client->loggedUser()->bookmarks();
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
            'access_token' => 'wubba_lubba_dub',
        ]);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetBookmarks()
    {
        $client = $this->getClientWithMapGetResponse([
            'users/me/bookmarks' => [200, file_get_contents(__DIR__ . '/Fixture/bookmarks.json')]
        ], ['access_token' => 'wubba_lubba_dub']);

        $bookmarks = $client->loggedUser()->bookmarks();

        $this->assertInstanceOf(BookmarkCollection::class, $bookmarks);
        $this->assertCount(3, $bookmarks);

        $bookmarks->each(function($bookmark) {
            $this->assertInstanceOf(Bookmark::class, $bookmark);
        });

        $this->assertInstanceOf(Bookmark::class, $bookmarks->first());
        $this->assertInstanceOf(Item::class, $bookmarks->first()->item());
        $this->assertEquals($bookmarks->first()->itemId(), $bookmarks->first()->item()->id());
    }
}