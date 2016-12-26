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

    $desEncrypt = new \Mcrypt\DesEncryptor("key", "iv");

Example 1: (3Des Encrypt and Decrypt)

    $str = "hello world!";
    $encrypt_str = $desEncrypt->encrypt3DES($str);
    echo $desEncrypt->decrypt3DES($encrypt_str);
    
    //will output "hello world!"
