<?php

namespace Tecnogo\MeliSdk\Entity\LoggedUser\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Entity\LoggedUser\User;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetUserItems
 *
 * @package Tecnogo\MeliSdk\Entity\Item\Api
 *
 * @internal
 */
final class GetRawUserItems extends AbstractTemplateAction
{
    const CACHE_TTL_IN_SECONDS = 180;

    /**
     * @var string
     */
    private $userId;
    /**
     * @var array
     */
    private $payload;
    /**
     * @var Factory
     */
    private $factory;

    /**
     * @param User $user
     * @param array $payload
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    public function __construct(Factory $factory, User $user, array $payload = [])
    {
        $this->userId = $user->id();
        $this->payload = $payload;
        $this->factory = $factory;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'users/' . $this->userId . '/items/search';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::GET;
    }

    /**
     * @return bool
     */
    public function requiresAccessToken()
    {
        return true;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return \Psr\SimpleCache\CacheInterface
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    protected function createCache()
    {
        return $this->factory->cache(static::class, static::CACHE_TTL_IN_SECONDS);
    }
}
