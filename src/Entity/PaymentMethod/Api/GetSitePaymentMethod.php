<?php

namespace Tecnogo\MeliSdk\Entity\PaymentMethod\Api;

use Tecnogo\MeliSdk\Api\AbstractTemplateAction;
use Tecnogo\MeliSdk\Cache\CacheStrategy;
use Tecnogo\MeliSdk\Config\SiteId;
use Tecnogo\MeliSdk\Request\Method;

/**
 * Class GetPaymentMethod
 *
 * @package Tecnogo\MeliSdk\Entity\PaymentMethods\Api
 */
final class GetSitePaymentMethod extends AbstractTemplateAction
{
    /**
     * @var SiteId|string
     */
    private $siteId;
    private $id;

    public function __construct($siteId, $id)
    {
        $this->siteId = $siteId;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return 'sites/' . $this->siteId . '/payment_methods';
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
        return CacheStrategy::LONG;
    }
}
