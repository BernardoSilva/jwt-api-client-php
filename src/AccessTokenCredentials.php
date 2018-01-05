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
    public function __construct($accessToken)
    {
        $this->setAccessToken($accessToken);
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }
}
