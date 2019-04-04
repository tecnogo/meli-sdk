<?php

namespace Tecnogo\MeliSdk\Site;

use Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException;

class SiteUrl
{
    const MLA = 'https://auth.mercadolibre.com.ar';
    const MLB = 'https://auth.mercadolivre.com.br';
    const MCO = 'https://auth.mercadolibre.com.co';
    const MCR = 'https://auth.mercadolibre.com.cr';
    const MEC = 'https://auth.mercadolibre.com.ec';
    const MLC = 'https://auth.mercadolibre.cl';
    const MLM = 'https://auth.mercadolibre.com.mx';
    const MLU = 'https://auth.mercadolibre.com.uy';
    const MLV = 'https://auth.mercadolibre.com.ve';
    const MPA = 'https://auth.mercadolibre.com.pa';
    const MPE = 'https://auth.mercadolibre.com.pe';
    const MPT = 'https://auth.mercadolibre.com.pt';
    const MRD = 'https://auth.mercadolibre.com.do';


    /**
     * @param $region
     * @return mixed
     * @throws InvalidSiteIdException
     */
    public static function getRegionAuthUrl($region)
    {
        if (!defined("self::$region")) {
            throw new InvalidSiteIdException($region);
        }

        return constant("self::$region") . '/authorization';
    }
}
