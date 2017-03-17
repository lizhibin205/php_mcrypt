lizhibin/php-mcrypt - Library
=============

"PHP加密解密类库"

Install via "composer require"
======
```shell
composer require lizhibin/php-mcrypt dev-master
```

Usage:
======
```php
$desEncrypt = new \Mcrypt\DesEncryptor("key", "iv");
```

Example 1: (3Des Encrypt and Decrypt)
```php
use Mcrypt\DesEncryptor;
use Mcrypt\String;

require 'bootstrap.php';

$desEncryptor = new DesEncryptor("1234567890123456", "12345678");
//设置加密key长度
$desEncryptor->setKeySize(192);
//设置加密方式，目前仅支持MCRYPT_MODE_CBC
$desEncryptor->setMode(MCRYPT_MODE_CBC);
//字符串补码，可设置为String::zeroPadding，String::pkcs5Padding，String::pkcs7Padding
$desEncryptor->setPaddingMode(String::pkcs7Padding);

$mcryptResult = $desEncryptor->encrypt3DES("hello world!");
echo base64_encode($mcryptResult), PHP_EOL;
echo $desEncryptor->decrypt3DES($mcryptResult);
//output:
//tpD3+3PSR/Tx0saMLxJVUg==
//hello world!
```