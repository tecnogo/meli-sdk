<?php

namespace Tecnogo\MeliSdk\Entity\User\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetRawUser
 *
 * @package Tecnogo\MeliSdk\User\Api
 * @internal
 */
final class GetRawUser extends AbstractTemplateAction
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
        return 'users/' . $this->id;
    }

    /**
     * @return bool
     */
    public function requiresAccessToken()
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
