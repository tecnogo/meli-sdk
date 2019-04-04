<?php

namespace Tecnogo\MeliSdk\Site;

use Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException;

/**
 * Class Site
 *
 * @package Tecnogo\MeliSdk\Site
 */
final class Site
{
    const MLA = 'MLA';
    const MLB = 'MLB';
    const MCO = 'MCO';
    const MCR = 'MCR';
    const MEC = 'MEC';
    const MLC = 'MLC';
    const MLM = 'MLM';
    const MLU = 'MLU';
    const MLV = 'MLV';
    const MPA = 'MPA';
    const MPE = 'MPE';
    const MPT = 'MPT';
    const MRD = 'MRD';

    /**
     * @param $siteId
     * @throws InvalidSiteIdException
     */
    public static function assert($siteId)
    {
        if (!defined("self::$siteId")) {
            throw new InvalidSiteIdException($siteId);
        }
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public static function all()
    {
        $reflectionClass = new \ReflectionClass(static::class);

        return array_values($reflectionClass->getConstants());
    }
}
