<?php

namespace Tecnogo\MeliSdk\Entity\User;

use Tecnogo\MeliSdk\Entity\AbstractEntity;

/**
 * Class User
 *
 * @package Tecnogo\MeliSdk\Entity\User
 *
 * @internal
 */
final class User extends AbstractEntity
{
    /**
     * @return int|null
     */
    public function id()
    {
        return $this->get('id');
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
    public function permalink()
    {
        return $this->get('permalink');
    }

    /**
     * @return string[]
     */
    public function tags()
    {
        return $this->get('tags', []);
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function hasTag($tag)
    {
        return in_array($tag, $this->tags());
    }

    /**
     * @return bool
     */
    public function verified()
    {
        return $this->hasTag(Tag::USER_INFO_VERIFIED);
    }

    /**
     * @return bool
     */
    public function developer()
    {
        return $this->hasTag(Tag::USER_DEVELOPER);
    }
}
