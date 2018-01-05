<?php

namespace BernardoSilva\JWTAPIClient;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;

class APIClient
{
    /**
     * Number of seconds until a quest timeout
     */
    const REQUEST_TIMEOUT = 5.0;

    /**
     * @var string
     */
    private $baseURI;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var ApiCredentials
     */
    private $credentials;

    /**
     * APIClient constructor.
     * @param string $baseURI
     * @param ApiCredentials $credentials
     */
    public function __construct($baseURI, ApiCredentials $credentials)
    {
        $this->setBaseURI($baseURI);
        $this->setCredentials($credentials);
    }

    /**
     * @param string $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get($uri, array $options = [])
    {
        return $this->getClient()->get($uri, $options);
    }

    /**
     * @param string $uri
     * @param $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete($uri, $options)
    {
        return $this->getClient()->delete($uri, $options);
    }

    /**
     * @param string $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function patch($uri, array $options = [])
    {
        return $this->getClient()->patch($uri, $options);
    }

    /**
     * @param string $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function post($uri, array $options = [])
    {
        return $this->getClient()->post($uri, $options);
    }

    /**
     * @param string $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function put($uri, array $options = [])
    {
        return $this->getClient()->put($uri, $options);
    }

    /**
     * Create a new Guzzle client to consume the API
     *
     * @return Client
     */
    private function createNewClient()
    {
        $accessToken = $this->getAccessToken();
        $stack = $this->createHandlerMiddlewareToAddAccessToken($accessToken);

        return new Client([
            'base_uri' => $this->getBaseURI(),
            'handler' => $stack,
            'timeout' => self::REQUEST_TIMEOUT
            ]);
    }

    /**
     * Create a new HandlerStack to add header with access token to be able to consume the API
     *
     * @param string $accessToken
     * @return HandlerStack
     */
    private function createHandlerMiddlewareToAddAccessToken($accessToken)
    {
        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());
        $stack->push($this->addHeader('Authorization', 'Bearer '. $accessToken));

        return $stack;
    }

    /**
     * @return string
     */
    private function getAccessToken()
    {
        if ($this->getCredentials() instanceof AccessTokenCredentials) {
            return $this->getCredentials()->getAccessToken();
        }

        $this->setKey($this->getCredentials()->getUsername());
        $this->setSecret($this->getCredentials()->getPassword());

        $client = new Client([
            'base_uri' => $this->getBaseURI(),
            'timeout' => self::REQUEST_TIMEOUT
        ]);
        $loginParams = [
            '_username' => $this->getKey(),
            '_password' => $this->getSecret()
        ];
        $response = $client->post('login_check', ['form_params' => $loginParams]);
        $loginResponseDecoded = json_decode($response->getBody()->getContents(), true);

        return $loginResponseDecoded['token'];
    }

    /**
     * @param $header
     * @param $value
     * @return \Closure
     */
    private function addHeader($header, $value)
    {
        return function (callable $handler) use ($header, $value) {
            return function (
                RequestInterface $request,
                array $options
            ) use (
                $handler,
                $header,
                $value
) {
                $request = $request->withHeader($header, $value);
                return $handler($request, $options);
            };
        };
    }

    /**
     * @return Client
     */
    private function getClient()
    {
        if (!$this->client) {
            $this->setClient($this->createNewClient());
        }

        return $this->client;
    }

    /**
     * @param Client $client
     */
    private function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getBaseURI()
    {
        return $this->baseURI;
    }

    /**
     * @param string $baseURI
     */
    private function setBaseURI($baseURI)
    {
        $this->baseURI = $baseURI;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    private function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     */
    private function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * @return AccessTokenCredentials|UsernameAndPasswordCredentials
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @param ApiCredentials $credentials
     */
    public function setCredentials(ApiCredentials $credentials)
    {
        $this->credentials = $credentials;
    }
}
