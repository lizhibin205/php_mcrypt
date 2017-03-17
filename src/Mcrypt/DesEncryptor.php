<?php
namespace Mcrypt;

use Mcrypt\String;
use Mcrypt\Exception;

/**
* 3DES加解密类
* @Author: 黎志斌
* @version: v1.0
* 2016年7月21日
*/
class DesEncryptor
{
    /**
    * 密钥长度
    * @var int
    */
    private $keySize;

    /**
    * 密钥
    * @var string
    */
    private $key;

    /**
    * 密钥偏移量
    * @var string
    */
    private $iv;

    /**
    * 算法模式
    * @var int
    */
    private $mode = MCRYPT_MODE_CBC;

    /**
    * 字符串偏移方式
    * @var int
    */
    private $paddingMode = String::zeroPadding;

    /**
    * 构造函数
    * @param string $key 密钥
    * @param string $iv 密钥偏移量
    */
    public function __construct($key, $iv)
    {
        $this->key = $key;
        $this->iv = $iv;
    }

    /**
    * 设置算法模式
    * @param int $keySize 设置密钥长度，可选择的值有
    * MCRYPT_MODE_CBC 
    */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
    * 设置密钥长度
    * @param int $keySize 设置密钥长度
    */
    public function setKeySize($keySize)
    {
        $this->keySize = $keySize;
    }

    /**
    * 设置补码方式
    * @param int $keySize 设置密钥长度
    */
    public function setPaddingMode($paddingMode)
    {
        $this->paddingMode = $paddingMode;
    }


    /**
    * 对字符串进行3DES加密
    * @param string 要加密的字符串
    * @return mixed 加密成功返回加密后的字符串，否则返回false
    * @Exception Mcrypt\Exception
    */
    public function encrypt3DES($str)
    {
        if (!in_array($this->mode, [MCRYPT_MODE_CBC], true)) {
            throw new Exception("加密模式不支持！");
        }
        $td = mcrypt_module_open(MCRYPT_3DES, "", $this->mode, "");
        if ($td === false) {
            throw new Exception("打开算法和模式对应的模块失败！");
        }

        //检查加密key的长度是否符合算法要求
        $keyMaxSize = mcrypt_enc_get_key_size($td);
        if (strlen($this->key) > $keyMaxSize) {
            throw new Exception("Key长度不符合规范，必须小于{$keyMaxSize}字节！");
        }
        $key = String::padding($this->key, $keyMaxSize, '0');

        //检查加密iv的长度是否符合算法要求
        $ivMaxSize = mcrypt_enc_get_iv_size($td);
        if (strlen($this->iv) > $ivMaxSize) {
            throw new Exception("IV长度不符合规范，必须小于{$ivMaxSize}字节！");
        }
        $iv = String::padding($this->iv, $ivMaxSize, '0');

        //初始化加密所需的缓冲区
        if (mcrypt_generic_init($td, $key, $this->iv) !== 0) {
            throw new Exception("初始化加密所需的缓冲区失败！");
        }

        //对$str进行分组处理
        $blockSize =  mcrypt_enc_get_block_size($td);
        switch ($this->paddingMode) {
            case String::pkcs5Padding:
                $str = String::pkcs5Padding($str);
                break;
            case String::pkcs7Padding:
                $str = String::pkcs7Padding($str, $blockSize);
                break;
            default:
                $str = String::zeroPadding($str, $blockSize);
        }

        $result = mcrypt_generic($td, $str);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        return $result;
    }

    /**
    * 对加密的字符串进行3DES解密
    * @param string 要解密的字符串
    * @return mixed 加密成功返回加密后的字符串，否则返回false
    */
    public function decrypt3DES($str)
    {
        if (!in_array($this->mode, [MCRYPT_MODE_CBC], true)) {
            throw new Exception("加密模式不支持！");
        }
        $td = mcrypt_module_open(MCRYPT_3DES, "", $this->mode, "");
        if ($td === false) {
            throw new Exception("打开算法和模式对应的模块失败！");
        }

        //检查加密key的长度是否符合算法要求
        $keyMaxSize = mcrypt_enc_get_key_size($td);
        if (strlen($this->key) > $keyMaxSize) {
            throw new Exception("Key长度不符合规范，必须小于{$keyMaxSize}字节！");
        }
        $key = String::padding($this->key, $keyMaxSize, '0');

        //检查加密iv的长度是否符合算法要求
        $ivMaxSize = mcrypt_enc_get_iv_size($td);
        if (strlen($this->iv) > $ivMaxSize) {
            throw new Exception("IV长度不符合规范，必须小于{$ivMaxSize}字节！");
        }
        $iv = String::padding($this->iv, $ivMaxSize, '0');

        if (mcrypt_generic_init($td, $key, $iv) !== 0) {
            throw new Exception("初始化加密所需的缓冲区失败！");
        }

        $result = mdecrypt_generic($td, $str);
        $blockSize =  mcrypt_enc_get_block_size($td);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        switch ($this->paddingMode) {
            case String::pkcs5Padding:
                $result = String::unPkcs5Padding($result);
                break;
            case String::pkcs7Padding:
                $result = String::unPkcs7Padding($result, $blockSize);
                break;
            default:
                $result = rtrim($result, chr(0));
        }

        return $result;
    }
}