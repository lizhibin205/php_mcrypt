<?php
class Mcrypt_DesEncryptorTest extends PHPUnit_Framework_TestCase
{
    public function additionProvider($key, $iv, $str)
    {
        return [
            ["key", "iv", "hello world!"],
        ];
    }

    /**
    * @dataProvider additionProvider
    */
    public function testEncryptAndDecrypt($key, $iv, $str)
    {
        $desEncryptor = new \Mcrypt\DesEncryptor($key, $iv);
        $encrypt_str = $desEncryptor->encrypt3DES($str);
        $decrypt_str = $desEncryptor->decrypt3DES($encrypt_str);
        $this->assertEquals($str, $decrypt_str);
    }
}