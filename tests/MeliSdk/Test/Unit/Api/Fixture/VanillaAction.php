<?php

namespace Tecnogo\MeliSdk\Test\Unit\Api\Fixture;

use Tecnogo\MeliSdk\Api\Action;
use Tecnogo\MeliSdk\Cache\CacheStrategy;
use Tecnogo\MeliSdk\Request\Method;

class VanillaAction implements Action
{
    /**
     * @param array $result
     * @return mixed
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
        return 'vanilla_action';
    }

    /**
     * @return bool
     */
    public function requiresAccessToken()
    {
        return false;
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

    /**
     * @return array
     */
    public function getPayload()
    {
        return [];
    }

    /**
     * @param \Exception $e
     * @return mixed
     * @throws \Exception
     */
    public function handleException(\Exception $e)
    {
        throw $e;
    }

    /**
     * @return string
     */
    public function getCacheKey()
    {
        return 'wubba_lubba_dub';
    }

    /**
     * @return string
     */
    public function getCacheStrategy()
    {
        return CacheStrategy::BRIEF;
    }
}