<?php

namespace Tecnogo\MeliSdk\Entity\LoggedUser;

use Tecnogo\MeliSdk\Entity\AbstractEntity;

/**
 * Class Bookmark
 *
 * @package Tecnogo\MeliSdk\Entity\LoggedUser
 *
 * @internal
 */
final class Bookmark extends AbstractEntity
{
    /**
     * @return string
     */
    public function date()
    {
        return $this->get('bookmarked_date');
    }

    /**
     * @return \Tecnogo\MeliSdk\Entity\Item\Item
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function item()
    {
        return $this->client->item($this->itemId());
    }

    /**
     * @return string
     */
    public function itemId()
    {
        return $this->get('item_id');
    }
}
