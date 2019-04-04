<?php

namespace Tecnogo\MeliSdk\Test\Api\Fixture;

use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Simple\NullCache;
use Tecnogo\MeliSdk\Api\Action;

class InvalidHttpMethodAction implements Action
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
        return false;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'INVALID_HTTP_METHOD';
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
     * @return CacheInterface
     */
    public function cache()
    {
        return new NullCache();
    }
}