<?php

namespace Tecnogo\MeliSdk\Entity\User\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Request\Exception\NotFoundException;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetBrands
 *
 * @package Tecnogo\MeliSdk\Entity\User\Api
 *
 * @internal
 */
final class GetUserBrands extends AbstractTemplateAction
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
        return 'users/' . $this->id . '/brands';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::GET;
    }

    /**
     * @param \Exception $e
     * @return array
     * @throws NotFoundException
     */
    public function handleException(\Exception $e)
    {
        $message = trim($e->getMessage());

        if ($e instanceof NotFoundException && $message === 'The resource official store was not found') {
            return [];
        }

        throw  $e;
    }
}
