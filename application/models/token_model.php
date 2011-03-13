<?php if ( ! defined('BASEPATH')) exit('No direct script acess allowed');

class Token_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    function get_token($code){
        $ret = false;
        $query = $this->db->query('select * from `token` where `code` = ? ', array($code));
        if($query){
            $result = $query->result();
            if($result){
                $ret = $result[0];
            }
        }
        return $ret;
    }
}
