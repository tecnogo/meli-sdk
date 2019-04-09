<?php

namespace Tecnogo\MeliSdk\Entity\Category\Api;


use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetRawCategoryAttributes
 *
 * @package Tecnogo\MeliSdk\Entity\Category\Api
 *
 * @final
 */
class GetRawCategoryAttributes extends AbstractTemplateAction
{
    private $categoryId;

    public function __construct($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'categories/' . $this->categoryId . '/attributes';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::GET;
    }
}
