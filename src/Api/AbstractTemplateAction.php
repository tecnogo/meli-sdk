<?php

namespace Tecnogo\MeliSdk\Api;

use Tecnogo\MeliSdk\Cache\CacheStrategy;

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
     * @return string
     */
    public function getCacheKey()
    {
        return md5($this->getMethod() . $this->getResource() . json_encode($this->getPayload()));
    }

    /**
     * @return string
     */
    public function getCacheStrategy()
    {
        return CacheStrategy::NO_CACHE;
    }
}
