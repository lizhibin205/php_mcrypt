<?php 
use Mcrypt\DesEncryptor;
use Mcrypt\String;

require 'bootstrap.php';

$desEncryptor = new DesEncryptor("1234567890123456", "12345678");
$desEncryptor->setKeySize(192);
$desEncryptor->setMode(MCRYPT_MODE_CBC);
$desEncryptor->setPaddingMode(String::pkcs7Padding);
$mcryptResult = $desEncryptor->encrypt3DES("hello world!");

echo base64_encode($mcryptResult), PHP_EOL;

echo $desEncryptor->decrypt3DES($mcryptResult);