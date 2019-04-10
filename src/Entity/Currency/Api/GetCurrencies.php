<?php

namespace Tecnogo\MeliSdk\Entity\Currency\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Entity\Currency\Collection;
use Tecnogo\MeliSdk\Entity\Currency\Currency;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetCurrencies
 *
 * @package Tecnogo\MeliSdk\Entity\Currency\Api
 *
 * @internal
 */
final class GetCurrencies extends AbstractTemplateAction
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * GetCurrencies constructor.
     *
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param array $result
     * @return Collection
     */
    public function handle(array $result = [])
    {
        return Collection::make($result, function ($currency) {
            return $this->factory->hydrate(Currency::class, $currency);
        });
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'currencies';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::GET;
    }

    /**
     * @return \Psr\SimpleCache\CacheInterface
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    protected function createCache()
    {
        return $this->factory->cache(static::class);
    }
}
