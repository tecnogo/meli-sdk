<?php

namespace Tecnogo\MeliSdk\Test\Unit\Site;

use PHPUnit\Framework\TestCase;
use Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException;
use Tecnogo\MeliSdk\Site\Site;
use Tecnogo\MeliSdk\Site\SiteUrl;

class SiteUrlTest extends TestCase
{
    /**
     * @throws InvalidSiteIdException
     * @throws \ReflectionException
     */
    public function testGetSiteUrl()
    {
        foreach (Site::all() as $siteId) {
            $url = SiteUrl::getRegionAuthUrl($siteId);

            $this->assertNotEmpty($url);
            $this->assertIsString($url);
        }
    }

    /**
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetInvalidSiteUrl()
    {
        $this->expectException(InvalidSiteIdException::class);

        SiteUrl::getRegionAuthUrl('wubba_lubba_dub');
    }
}