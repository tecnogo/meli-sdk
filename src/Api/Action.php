<?php

namespace Tecnogo\MeliSdk\Api;

use Psr\SimpleCache\CacheInterface;

/**
 * Interface Action
 *
 * @package Tecnogo\MeliSdk\Api
 *
 * @internal
 */
interface Action
{
    /**
     * @param array $result
     * @return mixed
     */
    public function handle(array $result = []);

    /**
     * @return string
     */
    public function getResource();

    /**
     * @return bool
     */
    public function requiresAccessToken();

    /**
     * @return bool
     */
    public function requiresAppId();

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return array
     */
    public function getPayload();

    /**
     * @param \Exception $e
     * @return mixed
     */
    public function handleException(\Exception $e);

    /**
     * @return CacheInterface
     */
    public function cache();

    /**
     * @return string
     */
    public function getCacheKey();
}
