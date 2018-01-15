<?php

namespace BernardoSilva\JWTAPIClient\Tests;

use BernardoSilva\JWTAPIClient\AccessTokenCredentials;
use BernardoSilva\JWTAPIClient\APIClient;
use BernardoSilva\JWTAPIClient\UsernameAndPasswordCredentials;
use GuzzleHttp\HandlerStack;
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

        $this->assertInstanceOf(AccessTokenCredentials::class, $client->getCredentials());
    }

    public function testGenerateClientOptionsContainsStackCallbackToAddTokenHeader()
    {
        $baseURI = 'https://api.chefs-em-casa.dev';
        $accessToken = 'user-jwt-token';
        $credentials = new AccessTokenCredentials($accessToken);
        $apiClient = new APIClient($baseURI, $credentials);

        $reflector = new \ReflectionClass(APIClient::class);
        $method = $reflector->getMethod('generateClientOptions');
        $method->setAccessible(true);

        $result = $method->invokeArgs($apiClient, []);

        $this->assertInstanceOf(HandlerStack::class, $result['handler']);
    }

    public function testGenerateClientOptionsContainDefaultValues()
    {
        $apiClient = new APIClient('https://my-api.com');

        $reflector = new \ReflectionClass(APIClient::class);
        $method = $reflector->getMethod('generateClientOptions');
        $method->setAccessible(true);

        $result = $method->invokeArgs($apiClient, []);

        $expectedOptions = [
            'base_uri' => 'https://my-api.com',
            'timeout' => 5
        ];

        $this->assertEquals($expectedOptions, $result);
    }

    public function testGenerateClientOptionsOverrideDefaults()
    {
        $options = [
            'timeout' => 30,
            'verify' => false
        ];
        $apiClient = new APIClient('https://my-api.com', null, $options);

        $reflector = new \ReflectionClass(APIClient::class);
        $method = $reflector->getMethod('generateClientOptions');
        $method->setAccessible(true);

        $result = $method->invokeArgs($apiClient, []);

        $expectedOptions = [
            'base_uri' => 'https://my-api.com',
            'timeout' => 30,
            'verify' => false
        ];

        $this->assertEquals($expectedOptions, $result);
    }
}
