<?php

namespace Tecnogo\MeliSdk\Entity\LoggedUser;

use Tecnogo\MeliSdk\Entity\AbstractEntity;
use Tecnogo\MeliSdk\Entity\LoggedUser\Api\GetBookmarks;
use Tecnogo\MeliSdk\Entity\LoggedUser\Api\GetNotifications;
use Tecnogo\MeliSdk\Entity\User\Api\GetUserBrands;

/**
 * Class User
 *
 * @package Tecnogo\MeliSdk\Entity\LoggedUser
 *
 * @internal
 */
final class User extends AbstractEntity
{
    /**
     * @return string|null
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    public function id()
    {
        return $this->id ?? $this->client->getAccessToken()->guessUserId() ?? $this->get('id');
    }

    /**
     * @return string
     */
    public function nickname()
    {
        return $this->get('nickname');
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->get('first_name');
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->get('last_name');
    }

    /**
     * @return string
     */
    public function getPermalink()
    {
        return $this->get('permalink');
    }

    /**
     * @return string
     */
    public function points()
    {
        return (int)$this->get('points');
    }

    /**
     * @return NotificationCollection
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function notifications()
    {
        return $this->client->exec(GetNotifications::class);
    }

    /**
     * @return BookmarkCollection
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function bookmarks()
    {
        return $this->client->exec(GetBookmarks::class);
    }

    /**
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    public function brands()
    {
        return $this->client->exec(GetUserBrands::class, ['id' => $this->id()]);
    }
}
