<?php if ( ! defined('BASEPATH')) exit('No direct script acess allowed');

class Token_model extends CI_Model {

    function __construct(){
        
    }

    function is_valid($token){
        $query = $this->db->query('select * from `token` where `token` = ?', array($token));
        return $query;
    }
}
