<?php

namespace Tecnogo\MeliSdk\Entity\LoggedUser\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Entity\LoggedUser\Notification;
use Tecnogo\MeliSdk\Entity\LoggedUser\NotificationCollection;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetNotifications
 *
 * @package Tecnogo\MeliSdk\LoggedUser\Api
 *
 * @internal
 */
final class GetNotifications extends AbstractTemplateAction
{
    /**
     * @var Factory
     */
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param array $result
     * @return NotificationCollection
     */
    public function handle(array $result = [])
    {
        return NotificationCollection::make($result['messages'] ?? [], function ($message) {
            return $this->factory->hydrate(Notification::class, $message);
        });
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'myfeeds';
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