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

$username = 'your-username';
$password = 'your-password';
$baseURI = 'api.your-domain.pt';

$credentials = new UsernameAndPasswordCredentials($username, $password);

// When using internally with other services can generate accessToken directly
$accessToken = $JWTManager->create($user);
$credentials = new AccessTokenCredentials($accessToken);

$client = new APIClient($baseURI, $credentials);

// e.g. Request types
$client->get();
$client->delete();
$client->patch();
$client->post();
$client->put();

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
