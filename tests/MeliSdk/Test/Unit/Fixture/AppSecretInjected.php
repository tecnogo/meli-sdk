<?php

namespace Tecnogo\MeliSdk\Test\Unit\Fixture;

use Tecnogo\MeliSdk\Config\AppSecret;

/**
 * Class AppSecretInjected
 *
 * @package Tecnogo\MeliSdk\Test\Fixture
 *
 * @internal
 */
final class AppSecretInjected
{
    public function __construct(AppSecret $appSecret)
    {
    }
}