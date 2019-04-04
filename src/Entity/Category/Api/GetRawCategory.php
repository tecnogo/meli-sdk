<?php

namespace Tecnogo\MeliSdk\Entity\Category\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetCategory
 *
 * @package Tecnogo\MeliSdk\Entity\Category\Api
 *
 * @internal
 */
final class GetRawCategory extends AbstractTemplateAction
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'categories/' . $this->id;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::GET;
    }
}
