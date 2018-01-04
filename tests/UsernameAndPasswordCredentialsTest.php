<?php

namespace BernardoSilva\JWTAPIClient\Tests;

use BernardoSilva\UsernameAndPasswordCredentials;
use PHPUnit\Framework\TestCase;

final class UsernameAndPasswordCredentialsTest extends TestCase
{

    public function testUsernameIsSetSuccessfully()
    {
        $credentials = new UsernameAndPasswordCredentials('my-user', 'my-pass123');

        $this->assertEquals('my-user', $credentials->getUsername());
    }

    public function testPasswordIsSetSuccessfully()
    {
        $credentials = new UsernameAndPasswordCredentials('my-user', 'my-pass123');

        $this->assertEquals('my-pass123', $credentials->getPassword());
    }
}
