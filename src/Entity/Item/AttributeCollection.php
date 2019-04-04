<?php

namespace Tecnogo\MeliSdk\Entity\Item;

use Tecnogo\MeliSdk\Collection\ListCollection;

/**
 * Class AttributeCollection
 *
 * @package Tecnogo\MeliSdk\Entity\Item
 *
 * @method Attribute first()
 * @method Attribute last()
 */
final class AttributeCollection extends ListCollection
{
    /**
     * @return array
     */
    public function simplifiedMap()
    {
        return $this->reduce(function ($groups, Attribute $attribute) {
            $groupName = $attribute->attributeGroupName();

            if (!array_key_exists($groupName, $groups)) {
                $groups[$groupName] = [];
            }

            $groups[$groupName][$attribute->name()] = $attribute->valueName();

            return $groups;
        }, []);
    }

    /**
     * @param string $attributeId
     * @return Attribute
     */
    public function get($attributeId)
    {
        return $this
            ->filter(function (Attribute $attribute) use ($attributeId) {
                return $attribute->id() === $attributeId;
            })
            ->first();
    }

    /**
     * @param string $attributeId
     * @return bool
     */
    public function hasAttribute($attributeId)
    {
        return !!$this->get($attributeId);
    }
}
