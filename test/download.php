<?php

error_reporting(E_ALL);

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



/* -------------------------------------  */
// $key = "pmt's my tool";
// $token_orig = sha1("anp's no programmer");
// $token = base64_encode(encrypt($key, $token_orig));

// $finfo = finfo_open(FILEINFO_MIME_TYPE);
// $file_type = finfo_file($finfo, $file_path);

$params = array(
    // "code" => "pmt",
    // "token" => $token
    "fetch_hash" => "c29a3afaf5df4eb0c5cfcc1630aeadaf854be833"
);

$ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, "http://fs.dev.aleiphoenix.com/download");
curl_setopt($ch, CURLOPT_URL, "http://fs.dev.chenlei.anjuke.com/donwload");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$ret = curl_exec($ch);
if($ret){
    $ret_value = json_decode($ret);
}

$download_key = $ret_value->download_key;

header("Location: http://fs.dev.aleiphoenix.com/download?download_key={$download_key}&fetch_hash={$params['fetch_hash']}");
