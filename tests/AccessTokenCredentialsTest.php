<?php

namespace BernardoSilva\JWTAPIClient\Tests;

use BernardoSilva\JWTAPIClient\AccessTokenCredentials;
use PHPUnit\Framework\TestCase;

final class AccessTokenCredentialsTest extends TestCase
{

    public function testAccessTokenIsSetSuccessfully()
    {
        $credentials = new AccessTokenCredentials('my-jwt-token');

        $this->assertEquals('my-jwt-token', $credentials->getAccessToken());
    }
}
