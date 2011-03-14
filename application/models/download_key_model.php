<?php if( ! defined('BASEPATH')) exit('No direct script acess');

class Download_key_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    function generate_key(){
        $key_meta = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";

        $ret = false;
        $key = '';
        for($i = 0; $i < 10; $i++){
            $key .= $key_meta[rand(0,63)];
        }
        $key = sha1($key);

        $inputarr = array(
            "key" => $key
        );
        $flag = $this->db->insert('download_key', $inputarr);
        if($flag){
            $ret = $key;
        }

        return $key;
    }

    function dispose_key($key){
        $flag = $this->db->query('delete from `download_key` where `key` = ? ', array($key));
        return $flag;
    }

    function is_valid($key){
        $ret = false;
        $query = $this->db->query(' select * from `download_key` where `key` = ?  ' , array($key));
        if($query){
            $result = $query->result();
            if($result){
                $ret = true;
            }
        }
        return $ret;
    }
}
