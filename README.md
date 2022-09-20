# php-string-encryption
Class to encrypt and decrypt a string using openssl and open64.

This repo is still in development
## Installation
This project using composer.
```
$ composer require djm56/php-string-encrytion
```
## Usage
Genrate random password.
```php
<?php

use RandomPassword\Password;

$password = new Password(10);
echo $password->generate();
```