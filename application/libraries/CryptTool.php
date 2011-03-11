<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CryptTool{

    function encrypt($inputkey, $text){

        if(!$inputkey && !$text){
            return false; 
        }
        else{
            $key = mhash(MHASH_SHA1, $inputkey);

            $encrypted = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $text, MCRYPT_MODE_ECB);
            return $encrypted;
        }
    }

    function decrypt($inputkey, $encrypted){
        if(!$inputkey && !$encrypted){
            return false; 
        }
        else{
            $key = mhash(MHASH_SHA1, $inputkey);

            $text = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $encrypted, MCRYPT_MODE_ECB);
            return $text;
        }
    }
}
