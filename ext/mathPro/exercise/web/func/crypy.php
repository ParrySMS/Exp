<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-23
 * Time: 14:02
 */

/** 加密函数
 * from https://blog.csdn.net/ranlv91/article/details/81916393
 * @param $string
 * @param $key
 * @return string
 */
function encrypt(string $string, $key = CRYPT_KEY):string
{

    // openssl_encrypt 加密不同Mcrypt，对秘钥长度要求，超出16加密结果不变
    $data = openssl_encrypt($string, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);

    $data = strtolower(bin2hex($data));

    return $data;
}

/** 解密函数
 *  from https://blog.csdn.net/ranlv91/article/details/81916393
 * @param $string
 * @param $key
 * @return string
 */
function decrypt(string $string, $key = CRYPT_KEY):string
{
    $decrypted = openssl_decrypt(hex2bin($string), 'AES-128-ECB', $key, OPENSSL_RAW_DATA);

    return $decrypted;
}



