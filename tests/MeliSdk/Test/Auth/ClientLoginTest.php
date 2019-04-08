<?php

namespace Tecnogo\MeliSdk\Test\Auth;

use PHPUnit\Framework\TestCase;
use Tecnogo\MeliSdk\Auth\Exception\InvalidAuthException;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Config\AccessToken;
use Tecnogo\MeliSdk\Request\ErrorMessageDictionary;
use Tecnogo\MeliSdk\Test\Mock\CreateMapResponsePostRequest;

class ClientLoginTest extends TestCase
{
    use CreateMapResponsePostRequest;

    /**
     * @throws \Tecnogo\MeliSdk\Auth\Exception\InvalidAuthException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testLoginWithInvalidClient()
    {
        $options = [
            'app_id' => 'app_id',
            'app_secret' => 'app_secret',
            'redirect_url' => 'redirect_url',
        ];

        $client = $this->getClientWithMapPostResponse([
            'oauth/token' => [400, file_get_contents(__DIR__ . '/Fixture/invalid_client.json')]
        ], $options);

        $this->expectException(InvalidAuthException::class);
        $this->expectExceptionMessage(ErrorMessageDictionary::INVALID_LOGIN_CODE);

        $client->login('wubba_lubba_dub');
    }

    /**
     * @throws \Tecnogo\MeliSdk\Auth\Exception\InvalidAuthException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testSuccessfulLogin()
    {
        $options = [
            'app_id' => 'app_id',
            'app_secret' => 'app_secret',
            'redirect_url' => 'redirect_url',
        ];

        $client = $this->getClientWithMapPostResponse([
            'oauth/token' => [200, file_get_contents(__DIR__ . '/Fixture/success.json')]
        ], $options);

        $client->login('wubba_lubba_dub');

        $accessToken = $client->getAccessToken();

        $this->assertInstanceOf(AccessToken::class, $accessToken);
        $this->assertEquals($accessToken->get(), 'APP_USR-6092-9999999-cb45c82853f6e620bb0deda096b128d3-8035443');
        $this->assertIsNumeric($accessToken->getExpires());
        $this->assertTrue($accessToken->valid());
        $this->assertTrue($accessToken->hasRefreshToken());

    }
}