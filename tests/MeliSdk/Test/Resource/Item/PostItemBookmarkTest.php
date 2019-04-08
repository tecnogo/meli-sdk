<?php

namespace Tecnogo\MeliSdk\Test\Resource\Item;

use PHPUnit\Framework\TestCase;
use Tecnogo\MeliSdk\Entity\Item\Item;
use Tecnogo\MeliSdk\Test\Mock\CreateMapResponsePostRequest;

class PostItemBookmarkTest extends TestCase
{
    use CreateMapResponsePostRequest;

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testBookmarkingAlreadyBookmarkedItem()
    {
        $client = $this->getClientWithMapPostResponse([
            'users/me/bookmarks' => [400, file_get_contents(__DIR__ . '/Fixture/already_bookmarked_item.json')]
        ], ['access_token' => 'wubba_lubba_dub']);

        $item = $client->item('MLA1111111');

        $result = $item->bookmark();


        $this->assertInstanceOf(Item::class, $result);
        $this->assertSame($item, $result);
    }
}
