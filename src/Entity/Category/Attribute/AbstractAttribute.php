<?php

namespace Tecnogo\MeliSdk\Entity\Category\Attribute;

use Tecnogo\MeliSdk\Entity\AbstractEntity;

/**
 * Class Attribute
 *
 * @package Tecnogo\MeliSdk\Entity\Category\Attribute
 *
 * @internal
 */
abstract class AbstractAttribute extends AbstractEntity implements Attribute
{
    /**
     * @return string
     */
    public function id()
    {
        return $this->get('id');
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->get('name');
    }

    /**
     * @return array
     */
    public function tags()
    {
        return $this->get('tags', []);
    }

    /**
     * @return bool
     */
    public function required()
    {
        return $this->hasTag(AttributeTag::REQUIRED);
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function hasTag($tag)
    {
        return in_array($tag, array_keys($this->tags()));
    }
}
