<?
class File_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    function insert_file($inputarr){
        $query = $this->db->insert('file', $inputarr);
        return $query;
    }

    function get_file($id){
        $query = $this->db->query('select * from `file` where `id` = ?', array($id));
        return $query;
    }
}
