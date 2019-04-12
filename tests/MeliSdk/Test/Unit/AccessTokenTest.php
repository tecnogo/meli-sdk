<?php

namespace Tecnogo\MeliSdk\Test\Unit;


use PHPUnit\Framework\TestCase;
use Tecnogo\MeliSdk\Config\AccessToken;

class AccessTokenTest extends TestCase
{
    public function testGuessUserFromValidToken()
    {
        $rawToken = 'APP_USR-1111111111111111-041206-74830acd5df06045cc9463e66c517b65-123456789';
        $accessToken = new AccessToken($rawToken);

        $this->assertIsString($accessToken->guessUserId());
        $this->assertEquals($accessToken->guessUserId(), '123456789');
    }

    public function testGuessUserFromEmptyToken()
    {
        $accessToken = new AccessToken('');

        $this->assertNull($accessToken->guessUserId());
    }

    public function testGuessUserFromInvalidToken()
    {
        $accessToken = new AccessToken('hueheuhe-huehe-hue');

        $this->assertNull($accessToken->guessUserId());
    }
}
