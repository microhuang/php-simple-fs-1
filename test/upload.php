<?php

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
$file_path = "/var/www/OReilly.Programming.Python.3rd.Ed.7z";

// $key = "pmt's my tool";
// $token_orig = sha1("anp's no programmer");
// $token = base64_encode(encrypt($key, $token_orig));

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$file_type = finfo_file($finfo, $file_path);

$params = array(
    // "code" => "pmt",
    // "token" => $token,
    "file" => "@".$file_path.";type=".$file_type
);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://fs.dev.aleiphoenix.com/upload");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

echo curl_exec($ch);

// print_r(json_decode($ret));
