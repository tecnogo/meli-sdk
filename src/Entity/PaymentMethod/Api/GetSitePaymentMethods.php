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
final class GetSitePaymentMethods extends AbstractTemplateAction
{
    /**
     * @var SiteId|string
     */
    private $siteId;

    public function __construct($siteId)
    {
        $this->siteId = $siteId;
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
        return CacheStrategy::DAY;
    }
}
