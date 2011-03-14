<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CryptTool{

    static function encrypt($inputkey, $text){

        if(!$inputkey && !$text){
            return false; 
        }
        else{
            $key = mhash(MHASH_SHA1, $inputkey);

            $encrypted = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $text, MCRYPT_MODE_ECB);
            return $encrypted;
        }
    }

    static function decrypt($inputkey, $encrypted){
        if(!$inputkey && !$encrypted){
            return false; 
        }
        else{
            $key = mhash(MHASH_SHA1, $inputkey);

            $text = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $encrypted, MCRYPT_MODE_ECB);
            return $text;
        }
    }

    static function get_file_fetch_hash($filename){
        $hash_meta = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

        $salt = '';
        for($i = 0; $i < 10;$i++){
            $salt .= $hash_meta[rand(0,63)];
        }

        $hash = sha1($filename.$salt);

        return $hash;
    }
}
