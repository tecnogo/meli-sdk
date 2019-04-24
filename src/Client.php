<?php

namespace Tecnogo\MeliSdk;

use Tecnogo\MeliSdk\Config\Config;
use Tecnogo\MeliSdk\Api\Action;
use Tecnogo\MeliSdk\Api\Facade;
use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Config\SiteId;
use Tecnogo\MeliSdk\Entity\Site\Api\GetSites;
use Tecnogo\MeliSdk\Exception\ContainerException;
use Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException;
use Tecnogo\MeliSdk\Site\Site;

/**
 * Class Client
 *
 * @package Tecnogo\MeliSdk
 */
final class Client
{
    /**
     * @var Factory
     */
    private $factory;
    /**
     * @var Config
     */
    private $config;
    /**
     * @var \Tecnogo\MeliSdk\Auth\Facade
     */
    private $auth;

    /**
     * @param array $options
     * @return Client
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     * @throws InvalidSiteIdException
     */
    public static function create(array $options = [])
    {
        return new static($options);
    }

    /**
     * Client constructor.
     *
     * @param string|null $appId
     * @param string|null $appSecret
     * @param array $options
     * @throws ContainerException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     * @throws Exception\MissingConfigurationException
     */
    private function __construct(array $options = [])
    {
        $this->createConfig($options);
        $this->createFactory($options['definitions'] ?? []);
        $this->auth = $this->make(\Tecnogo\MeliSdk\Auth\Facade::class);
    }

    /**
     * @param $name
     * @param array $parameters
     * @return mixed
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     */
    public function make($name, array $parameters = [])
    {
        return $this->factory->make($name, $parameters);
    }

    /**
     * @return \Tecnogo\MeliSdk\Api\Facade
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     */
    public function api()
    {
        return $this->make(Facade::class);
    }

    /**
     * @param string $actionClass
     * @param array $parameters
     * @return mixed
     * @throws ContainerException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws Exception\MissingConfigurationException
     */
    public function exec($actionClass, $parameters = [])
    {
        $action = $this->make($actionClass, $parameters);

        if (!($action instanceof Action)) {
            throw new \InvalidArgumentException("Class $action should implement Tecnogo\MeliSdk\\Api\\Action");
        }

        return $this->api()->exec($action);
    }

    /**
     * @return Entity\Site\Collection
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     * @throws Request\Exception\RequestException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function sites()
    {
        return \Tecnogo\MeliSdk\Entity\Site\Collection::make($this->exec(GetSites::class), function ($site) {
            return $this->lazyEntity(
                \Tecnogo\MeliSdk\Entity\Site\Site::class,
                \Tecnogo\MeliSdk\Entity\Site\Api\GetSite::class,
                $site['id']
            );
        });
    }

    /**
     * @return \Tecnogo\MeliSdk\Entity\LoggedUser\User:
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     */
    public function loggedUser()
    {
        return $this
            ->make(\Tecnogo\MeliSdk\Entity\LoggedUser\User::class, [
                'source' => function () {
                    return $this->exec(\Tecnogo\MeliSdk\Entity\LoggedUser\Api\GetRawUser::class);
                }
            ]);
    }

    /**
     * @param string|int $id
     * @return \Tecnogo\MeliSdk\Entity\User\User
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     */
    public function user($id)
    {
        return $this->lazyEntity(
            \Tecnogo\MeliSdk\Entity\User\User::class,
            \Tecnogo\MeliSdk\Entity\User\Api\GetRawUser::class,
            $id
        );
    }

    /**
     * @param SiteId|null $siteId
     * @return \Tecnogo\MeliSdk\Entity\Category\Collection
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     * @throws Request\Exception\RequestException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function categories(SiteId $siteId = null)
    {
        $payload = $siteId ? ['siteId' => $siteId] : [];

        return $this->exec(\Tecnogo\MeliSdk\Entity\Category\Api\GetCategories::class, $payload);
    }

    /**
     * @param $id
     * @return \Tecnogo\MeliSdk\Entity\Category\Category
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function category($id)
    {
        return $this->lazyEntity(
            \Tecnogo\MeliSdk\Entity\Category\Category::class,
            \Tecnogo\MeliSdk\Entity\Category\Api\GetRawCategory::class,
            $id
        );
    }

    /**
     * @return \Tecnogo\MeliSdk\Entity\Currency\Collection
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function currencies()
    {
        return $this->exec(\Tecnogo\MeliSdk\Entity\Currency\Api\GetCurrencies::class);
    }

    /**
     * @param SiteId|null $siteId
     * @return \Tecnogo\MeliSdk\Entity\ListingType\Collection
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     * @throws Request\Exception\RequestException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function listingTypes(SiteId $siteId = null)
    {
        $payload = $siteId ? ['siteId' => $siteId] : [];

        return $this->exec(\Tecnogo\MeliSdk\Entity\ListingType\Api\GetListingTypes::class, $payload);
    }

    /**
     * @return \Tecnogo\MeliSdk\Entity\LoggedUser\NotificationCollection
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     * @throws Request\Exception\RequestException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function notifications()
    {
        return $this->loggedUser()->notifications();
    }

    /**
     * @return \Tecnogo\MeliSdk\Entity\LoggedUser\BookmarkCollection
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     * @throws Request\Exception\RequestException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function bookmarks()
    {
        return $this->loggedUser()->bookmarks();
    }

    /**
     * @param string $search
     * @return \Tecnogo\MeliSdk\Entity\Category\CategoryPrediction
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function predictCategory($search)
    {
        return $this->exec(\Tecnogo\MeliSdk\Entity\Category\Api\GetCategoryPrediction::class, [
            'search' => $search
        ]);
    }

    /**
     * @param string $id
     * @return \Tecnogo\MeliSdk\Entity\Item\Item
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     */
    public function item($id)
    {
        return $this->lazyEntity(
            \Tecnogo\MeliSdk\Entity\Item\Item::class,
            \Tecnogo\MeliSdk\Entity\Item\Api\GetRawItem::class,
            $id
        );
    }

    /**
     * @param string $id
     * @return \Tecnogo\MeliSdk\Entity\Item\Item
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     */
    public function picture($id)
    {
        return $this->lazyEntity(
            \Tecnogo\MeliSdk\Entity\Picture\Picture::class,
            \Tecnogo\MeliSdk\Entity\Picture\Api\GetRawPicture::class,
            $id
        );
    }

    /**
     * @param $entity
     * @param $action
     * @param $id
     * @return mixed
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     */
    private function lazyEntity($entity, $action, $id)
    {
        return $this->make($entity, [
            'id' => $id,
            'source' => function () use ($action, $id) {
                return $this->exec($action, ['id' => $id]);
            }
        ]);
    }

    /**
     * @param array $options
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    private function createConfig(array $options = [])
    {
        $this->config = (new Config())
            ->setAppId($options['app_id'] ?? null)
            ->setAppSecret($options['app_secret'] ?? null)
            ->setAccessToken($options['access_token'] ?? null)
            ->setSiteId($options['site_id'] ?? Site::MLA)
            ->setRedirectUrl($options['redirect_url'] ?? null)
            ->setApiUrl($options['api_url'] ?? 'https://api.mercadolibre.com/');
    }

    /**
     * @param array $definitions
     * @throws ContainerException
     * @throws Exception\MissingConfigurationException
     */
    private function createFactory(array $definitions = [])
    {
        $definitions[Client::class] = $this; // FIXME: Do not use Client as dependency

        $this->factory = new Factory($this->getConfig(), $definitions);
    }

    /**
     * @return Factory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return string
     * @throws Exception\MissingConfigurationException
     * @throws InvalidSiteIdException
     */
    public function getAuthUrl()
    {
        return $this->auth->getAuthUrl();
    }

    /**
     * @return \Tecnogo\MeliSdk\Config\AccessToken
     * @throws Exception\MissingConfigurationException
     */
    public function getAccessToken()
    {
        return $this->config->getAccessToken();
    }

    /**
     * @param $code
     * @return $this
     * @throws Auth\Exception\InvalidAuthException
     * @throws Exception\MissingConfigurationException
     * @throws Request\Exception\RequestException
     * @throws ContainerException
     */
    public function login($code)
    {
        $this->auth->login($code);

        return $this;
    }
}
