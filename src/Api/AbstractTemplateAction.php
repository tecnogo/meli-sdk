<?php

namespace Tecnogo\MeliSdk\Api;

use Symfony\Component\Cache\Simple\NullCache;

/**
 * Class AbstractTemplateAction
 *
 * @package Tecnogo\MeliSdk\Api
 *
 * @internal
 */
abstract class AbstractTemplateAction implements Action
{
    /**
     * @param array $result
     * @return array
     */
    public function handle(array $result = [])
    {
        return $result;
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
     * @return array
     */
    public function getPayload()
    {
        return [];
    }

    /**
     * @param \Exception $e
     * @return mixed|void
     * @throws \Exception
     */
    public function handleException(\Exception $e)
    {
        throw $e;
    }

    /**
     * @return \Psr\SimpleCache\CacheInterface
     */
    public function cache()
    {
        return $this->cache ?? $this->cache = $this->createCache();
    }

    /**
     * @return \Psr\SimpleCache\CacheInterface
     */
    protected function createCache()
    {
        return new NullCache();
    }
}
