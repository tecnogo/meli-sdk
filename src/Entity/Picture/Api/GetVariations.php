<?php

namespace Tecnogo\MeliSdk\Entity\Picture\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Entity\Picture\VariationCollection;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetVariations
 *
 * @package Tecnogo\MeliSdk\Entity\Picture\Api
 *
 * @internal
 */
final class GetVariations extends AbstractTemplateAction
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @param array $result
     * @return mixed
     */
    public function handle(array $result = [])
    {
        return $result['variations'] ?? [];
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'pictures/' . $this->id;
    }

    /**
     * @return bool
     */
    public function requiresAppId()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::GET;
    }
}
