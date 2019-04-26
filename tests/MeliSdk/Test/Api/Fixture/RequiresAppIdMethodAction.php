<?php

namespace Tecnogo\MeliSdk\Test\Api\Fixture;

use Tecnogo\MeliSdk\Api\Action;
use Tecnogo\MeliSdk\Cache\CacheStrategy;

class RequiresAppIdMethodAction implements Action
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
        return 'foo';
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
        return true;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'GET';
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
    public function getCacheStrategy()
    {
        return CacheStrategy::NO_CACHE;
    }

    /**
     * @return string
     */
    public function getCacheKey()
    {
        return 'wubba_lubba_dub';
    }
}