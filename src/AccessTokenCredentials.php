<?php

namespace BernardoSilva\JWTAPIClient;

final class AccessTokenCredentials implements ApiCredentials
{
    /**
     * @var string
     */
    private $accessToken;

    /**
     * AccessTokenCredentials constructor.
     * @param string $accessToken
     */
    public function __construct(string $accessToken)
    {
        $this->setAccessToken($accessToken);
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }
}
