<?php

namespace Tecnogo\MeliSdk\Entity\Category\Attribute;

/**
 * Class AttributeTag
 *
 * @package Tecnogo\MeliSdk\Entity\Category\Attribute
 */
final class AttributeTag
{
    const ALLOW_VARIATIONS = 'allow_variations';
    const CATALOG_REQUIRED = 'catalog_required';
    const DEFINES_PICTURE = 'defines_picture';
    const FIXED = 'fixed';
    const HIDDEN = 'hidden';
    const MULTIVALUED = 'multivalued';
    const OTHERS = 'others';
    const READ_ONLY = 'read_only';
    const REQUIRED = 'required';
    const USED_HIDDEN = 'used_hidden';
    const VALIDATE = 'validate';
    const VARIATION_ATTRIBUTE = 'variation_attribute';

    public static function validate($tag)
    {
        $tag = strtoupper($tag);

        return defined("static::$tag");
    }
}
