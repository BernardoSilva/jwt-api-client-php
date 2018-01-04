<?php

namespace BernardoSilva\JWTAPIClient\Tests;

use BernardoSilva\AccessTokenCredentials;
use BernardoSilva\APIClient;
use BernardoSilva\UsernameAndPasswordCredentials;
use PHPUnit\Framework\TestCase;

final class APIClientTest extends TestCase
{
    private $client;

    /**
     * @param APIClient $client
     */
    private function setClient(APIClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return APIClient
     */
    private function getClient()
    {
        return $this->client;
    }

    public function setup()
    {
        $baseURI = 'https://api.chefs-em-casa.dev';
        $apiKey = 'my-key';
        $apiSecret = 'my-api-secret';

        $credentials = new UsernameAndPasswordCredentials($apiKey, $apiSecret);
        $client = new APIClient($baseURI, $credentials);

        $this->setClient($client);
    }

    public function testCreateNewInstance()
    {
        $this->assertInstanceOf(APIClient::class, $this->getClient());
    }

    public function testBaseURIIsSetSuccessfully()
    {
        $baseURI = $this->getClient()->getBaseURI();

        $this->assertEquals('https://api.chefs-em-casa.dev', $baseURI);
    }

    public function testUsernameAndPasswordCredentialsAreSetSuccessfully()
    {
        $this->assertInstanceOf(UsernameAndPasswordCredentials::class, $this->getClient()->getCredentials());
    }

    public function testAccessTokenCredentialsIsSetSuccessfully()
    {
        $baseURI = 'https://api.chefs-em-casa.dev';
        $accessToken = 'user-jwt-token';
        $credentials = new AccessTokenCredentials($accessToken);
        $client = new APIClient($baseURI, $credentials);

        $this->setClient($client);

        $this->assertInstanceOf(AccessTokenCredentials::class, $this->getClient()->getCredentials());
    }
}
