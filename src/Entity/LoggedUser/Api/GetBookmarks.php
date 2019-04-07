<?php

namespace Tecnogo\MeliSdk\Entity\LoggedUser\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Entity\LoggedUser\Bookmark;
use Tecnogo\MeliSdk\Entity\LoggedUser\BookmarkCollection;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetBookmarks
 *
 * @package Tecnogo\MeliSdk\Entity\LoggedUser\Api
 *
 * @internal
 */
final class GetBookmarks extends AbstractTemplateAction
{
    /**
     * @var Factory
     */
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param array $result
     * @return BookmarkCollection
     */
    public function handle(array $result = [])
    {
        return BookmarkCollection::make($result ?? [], function ($bookmark) {
            return $this->factory->hydrate(Bookmark::class, $bookmark);
        });
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'users/me/bookmarks';
    }

    /**
     * @return bool
     */
    public function requiresAccessToken()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::GET;
    }
}
