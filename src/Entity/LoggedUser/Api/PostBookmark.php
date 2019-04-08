<?php

namespace Tecnogo\MeliSdk\Entity\LoggedUser\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Request\ErrorMessageDictionary;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class DeleteBookmark
 *
 * @package Tecnogo\MeliSdk\Entity\LoggedUser\Api
 *
 * @internal
 */
final class PostBookmark extends AbstractTemplateAction
{
    private $itemId;

    /**
     * DeleteBookmark constructor.
     *
     * @param string $itemId
     */
    public function __construct($itemId)
    {
        $this->itemId = $itemId;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'users/me/bookmarks';
    }

    public function requiresAccessToken()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::POST;
    }

    public function getPayload()
    {
        return [
            'item_id' => $this->itemId
        ];
    }

    public function handleException(\Exception $e)
    {
        if ($e->getMessage() !== ErrorMessageDictionary::ITEM_ALREADY_BOOKMARKED) {
            parent::handleException($e);
        }
    }
}
