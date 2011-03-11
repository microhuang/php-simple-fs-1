<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
       
class DirTool{

    function recur_mkdir($path, $seperator = "/"){
        if($path){
            $folders = explode($seperator, $path);
            if($folders){
                $current_path = '';
                foreach($folders as $folder){
                    $current_path .= $folder.$seperator;
                    if(!file_exists($current_path) && $current_path){
                        echo "making path {$current_path}","\n";
                        mkdir($current_path);
                    }
                }
            }
            return true;
        }
        else{
            return false;
        }
    }
}
