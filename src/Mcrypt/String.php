<?php 
namespace Mcrypt;

class String
{
    const zeroPadding  = 0;
    const pkcs5Padding = 1;
    const pkcs7Padding = 2;

    public static function padding($string, $length, $char)
    {
        $strLength = strlen($string);
        if ($strLength > $length) {
            return substr($string, 0, $length);
        } else if($strLength < $length) {
            return str_pad($string, $length, $char);
        }
        return $string;
    }

    /**
    * 使用0补齐字符串
    * @param string $string
    * @param int $blockSize 
    * @return string
    */
    public static function zeroPadding($string, $blockSize)
    {
        $strLength = strlen($string);
        $padding = $blockSize - ($strLength % $blockSize);
        return self::padding($string, $strLength + $padding, chr(0));
    }

    /**
    * 使用pkcs5Padding补齐字符串，块固定是8位
    * @param string $string
    * @return string
    */
    public static function pkcs5Padding($string)
    {
        $strLength = strlen($string);
        $padding = 8 - ($strLength % 8);
        return self::padding($string, $strLength + $padding, chr($padding));
    }

    /**
    * 删除pkcs5Padding补齐字符串，块固定是8位
    * @param string $string
    * @return string
    */
    public static function unPkcs5Padding($string)
    {
        $padding = ord($string{strlen($string) - 1});
        return substr($string, 0, -1 * $padding);
    }

    /**
    * 使用pkcs7Padding补齐字符串，块固定是8位
    * @param string $string
    * @param int $blockSize 
    * @return string
    */
    public static function pkcs7Padding($string, $blockSize)
    {
        $strLength = strlen($string);
        $padding = $blockSize - ($strLength % $blockSize);
        return self::padding($string, $strLength + $padding, chr($padding));
    }

    /**
    * 删除pkcs7Padding补齐字符串
    * @param string $string
    * @return string
    */
    public static function unPkcs7Padding($string)
    {
        $padding = ord($string{strlen($string) - 1});
        return substr($string, 0, -1 * $padding);
    }
}