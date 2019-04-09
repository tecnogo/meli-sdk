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
final class Attribute extends AbstractEntity
{
    /**
     * @return string|null
     */
    public function type()
    {
        return $this->get('value_type');
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

    /**
     * @return array
     */
    public function values()
    {
        return $this->get('values');
    }

    /**
     * @return array
     */
    public function allowedUnits()
    {
        return $this->get('allowed_units');
    }

    /**
     * @return mixed
     */
    public function defaultUnit()
    {
        return $this->get('default_unit');
    }
}
