<?php

namespace Tecnogo\MeliSdk\Entity\Currency\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Cache\CacheStrategy;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetCurrency
 *
 * @package Tecnogo\MeliSdk\Entity\Currency\Api
 *
 * @internal
 */
final class GetCurrency extends AbstractTemplateAction
{
    /**
     * @var string
     */
    private $id;

    /**
     * GetCurrencies constructor.
     *
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'currencies/' . $this->id;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return Method::GET;
    }

    /**
     * @return string
     */
    public function getCacheStrategy()
    {
        return CacheStrategy::FOREVER;
    }
}
