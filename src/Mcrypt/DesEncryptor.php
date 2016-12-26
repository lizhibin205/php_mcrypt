<?php
/**
* 3DES加解密类
* @Author: 黎志斌
* @version: v1.0
* 2016年7月21日
*/
namespace Mcrypt;

class DesEncryptor
{
    private $_key;
    private $_iv;
    public function __construct($key, $iv)
    {
        $this->_key = $key;
        $this->_iv = $iv;
    }

    /**
    * 对字符串进行3DES加密
    * @param string 要加密的字符串
    * @return mixed 加密成功返回加密后的字符串，否则返回false
    */
    public function encrypt3DES($str)
    {
        $td = mcrypt_module_open(MCRYPT_3DES, "", MCRYPT_MODE_CBC, "");
        if ($td === false) {
            return false;
        }
        //检查加密key，iv的长度是否符合算法要求
        $key = $this->fixLen($this->_key, mcrypt_enc_get_key_size($td));
        $iv = $this->fixLen($this->_iv, mcrypt_enc_get_iv_size($td));
        
        //加密数据长度处理
        $str = $this->strPad($str, mcrypt_enc_get_block_size($td));
        
        if (mcrypt_generic_init($td, $key, $iv) !== 0) {
            return false;
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
        $td = mcrypt_module_open(MCRYPT_3DES, "", MCRYPT_MODE_CBC, "");
        if ($td === false) {
            return false;
        }
        
        //检查加密key，iv的长度是否符合算法要求
        $key = $this->fixLen($this->_key, mcrypt_enc_get_key_size($td));
        $iv = $this->fixLen($this->_iv, mcrypt_enc_get_iv_size($td));
        
        if (mcrypt_generic_init($td, $key, $iv) !== 0) {
            return false;
        }
        
        $result = mdecrypt_generic($td, $str);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        
        return $this->strUnPad($result);
    }

    /**
    * 返回适合算法长度的key，iv字符串
    * @param string $str key或iv的值
    * @param int $td_len 符合条件的key或iv长度
    * @return string 返回处理后的key或iv值
    */
    private function fixLen($str, $td_len)
    {
        $str_len = strlen($str);
        if ($str_len > $td_len) {
            return substr($str, 0, $td_len);
        } else if($str_len < $td_len) {
            return str_pad($str, $td_len, '0');
        }
        return $str;
    }

    /**
    * 返回适合算法的分组大小的字符串长度，末尾使用\0补齐
    * @param string $str 要加密的字符串
    * @param int $td_group_len 符合算法的分组长度
    * @return string 返回处理后字符串
    */
    private function strPad($str, $td_group_len)
    {
        $padding_len = $td_group_len - (strlen($str) % $td_group_len);
        return str_pad($str, strlen($str) + $padding_len, "\0");
    }

    /**
    * 去除末尾的\0补齐
    * @param string $str 要加密的字符串
    * @return string 返回处理后字符串
    */
    private function strUnPad($str)
    {
        return rtrim($str, "\0");
    }
}