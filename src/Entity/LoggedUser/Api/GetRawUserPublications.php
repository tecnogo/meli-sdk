<?php

namespace Tecnogo\MeliSdk\Entity\LoggedUser\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetRawUser
 *
 * @package Tecnogo\MeliSdk\LoggedUser\Api
 *
 * @internal
 */
final class GetRawUserPublications extends AbstractTemplateAction
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @param array $result
     * @return array
     */
    public function handle(array $result = [])
    {
       return $result;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'users/' . $this->id . '/items/search';
    }

    /**
     * @return bool
     */
    public function requiresAccessToken()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function requiresAppId()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::GET;
    }
}