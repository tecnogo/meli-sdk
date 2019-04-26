<?php

namespace Tecnogo\MeliSdk\Site;

use Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException;

class SiteUrl
{
    /**
     * @param $region
     * @return mixed
     * @throws InvalidSiteIdException
     */
    public static function getRegionAuthUrl($region)
    {
        return 'https://auth.mercadolibre.com/authorization';
    }
}
