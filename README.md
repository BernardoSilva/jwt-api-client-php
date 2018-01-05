# JWT API Client for PHP

Jason Web Token API client is a library to facilitate consuming API's that require JWT token as authentication. 

[![Latest Stable Version](https://poser.pugx.org/bernardosilva/jwt-api-client-php/v/stable)](https://packagist.org/packages/bernardosilva/jwt-api-client-php)
[![Total Downloads](https://poser.pugx.org/bernardosilva/jwt-api-client-php/downloads)](https://packagist.org/packages/bernardosilva/jwt-api-client-php)
[![Build Status](https://travis-ci.org/BernardoSilva/jwt-api-client-php.svg?branch=master)](https://travis-ci.org/BernardoSilva/jwt-api-client-php)
[![License](https://poser.pugx.org/bernardosilva/jwt-api-client-php/license)](https://packagist.org/packages/bernardosilva/jwt-api-client-php)

## How to Install

```
$ composer require bernardosilva/jwt-api-client-php
```

## How to use

```php
use BernardoSilva\JWTAPIClient\APIClient;
use BernardoSilva\JWTAPIClient\AccessTokenCredentials;

$username = 'your-username';
$password = 'your-password';
$baseURI = 'api.your-domain.pt';


$client = new APIClient($baseURI);
$options = [
    'verify' => false, // might need this if API uses self signed certificate
    'form_params' => [
        'key' => $username,
        'password' => $password
    ]
];

// authenticate on API to get token
$response = $client->post('/api/v1/auth/login', $options);
$loginResponseDecoded = json_decode($response->getBody()->getContents(), true);

$credentials = new AccessTokenCredentials($loginResponseDecoded['access_token']);
$client->setCredentials($credentials);

// e.g. Request types
$client->get();
$client->delete();
$client->patch();
$client->post();
$client->put();

```

Example of how to get access token without requesting the API:

```
// When using internally with other services can generate accessToken directly
$accessToken = $JWTManager->create($user);
$credentials = new AccessTokenCredentials($accessToken);
```


## How to contribute

* Fork project
* Clone it to your machine
* Install dependencies using `composer install`
* Open a Pull Request


### How to test

```
$ ./vendor/bin/phpunit
```


## Created by

* [Bernardo Silva](https://www.bernardosilva.com)

## License

The source code is licensed under GPL v3. License is available [here](/LICENSE).
