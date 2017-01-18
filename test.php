<?php 
require 'bootstrap.php';
$str = "hello world!";
$desEncrypt = new \Mcrypt\DesEncryptor("key", "iv");
$encrypt_str = $desEncrypt->encrypt3DES($str);
echo $desEncrypt->decrypt3DES($encrypt_str);