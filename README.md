# php-string-encryption
Class to encrypt and decrypt a string using openssl and open64.

This repo is still in development
## Installation
This project using composer.
```
$ composer require djm56/php-string-encrytion
```
## Usage
Define constants the encrytion_key please change to something unique, the encrytion_type can stay the same.
```php
define('ENCRYPTION_KEY', 'abcdefghij1234');
define('ENCRYPTION_TYPE', 'AES-128-CBC');
```

How to encrypt and decrypt:
```php

use StringEncryption\Encryption;

$encryptedtext = Encryption::encrypt('test string');
$decryptedtext = Encryption::decrypt('encrypted string');
```