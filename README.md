# PHP String Encryption
Class to encrypt and decrypt a string using openssl and open64.

I have used this in the past to encrypt/decrypt data at rest inside cookies that get used server side, or to  encrypt/decrypt data at rest inside database.

This repo is still in development

## Installation
This project is using composer.
```
$ composer require djm56/php-string-encrytion
```
## Usage
Define constants the encrytion_key please change to something unique, the encrytion_type can stay the same.
```php
define('ENCRYPTION_KEY', 'abcdefghij1234');
define('ENCRYPTION_TYPE', 'AES-128-CBC');
```

Choosing the correct Encrytption type or cipher use the available php function to list them from instruction on this page

https://www.php.net/manual/en/function.openssl-get-cipher-methods.php


How to encrypt and decrypt:
```php

use StringEncryption\Encryption;

$encryptedtext = Encryption::encrypt('test string');
$decryptedtext = Encryption::decrypt('encrypted string');
```