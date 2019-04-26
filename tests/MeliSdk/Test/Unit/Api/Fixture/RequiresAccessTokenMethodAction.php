<?php

namespace Tecnogo\MeliSdk\Test\Unit\Api\Fixture;

use Tecnogo\MeliSdk\Api\Action;
use Tecnogo\MeliSdk\Cache\CacheStrategy;

class RequiresAccessTokenMethodAction implements Action
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
        return 'requires_access_token';
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
        return CacheStrategy::BRIEF;
    }

    /**
     * @return string
     */
    public function getCacheKey()
    {
        return 'requires_access_token_cache_key';
    }
}