<?php
class Mcrypt_DesEncryptorTest extends PHPUnit_Framework_TestCase
{
    /**
    * @dataProvider additionEncryptProvider
    */
    public function testEncrypt($key, $iv, $keySize, $mode, $paddingMode, $str, $base64Result)
    {
        $desEncryptor = new Mcrypt\DesEncryptor($key, $iv);
        $desEncryptor->setKeySize($keySize);
        $desEncryptor->setMode($mode);
        $desEncryptor->setPaddingMode($paddingMode);
        $mcryptResult = $desEncryptor->encrypt3DES($str);
        $this->assertEquals(base64_encode($mcryptResult), $base64Result);

        $this->assertEquals($str, $desEncryptor->decrypt3DES($mcryptResult));
    }

    public function additionEncryptProvider()
    {
        //array(key, iv, key_length, mode, paddingMode, string, result of 3des mcrypt and base64_encode)
        return [
            ["1234567890123456", "12345678", 192, MCRYPT_MODE_CBC, Mcrypt\String::pkcs5Padding, "hello world!", "tpD3+3PSR/Tx0saMLxJVUg=="],
        ];
    }
}