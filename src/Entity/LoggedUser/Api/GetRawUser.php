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
final class GetRawUser extends AbstractTemplateAction
{
    /**
     * @return string
     */
    public function getResource()
    {
        return 'users/me';
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