<? if ( ! defined('BASEPATH')) exit('No direct script acess allowed');

class File_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    public function insert_file($inputarr){
        $ret = false;
        $query = $this->db->insert('file', $inputarr);
        if($query){
            $ret = $this->get_last_file();
        }
        return $ret;
    }

    public function get_file($fetch_hash){
        $query = $this->db->query('select * from `file` where `fetch_hash` = ?', array($fetch_hash));
        return $query;
    }

    public function get_file_by_id($id){
        $query = $this->db->query('select * from `file` where `id` = ?', array($id));
        return $query;
    }

    public function get_file_by_file_hash($hash){
        $ret = false;
        $query = $this->db->query('select * from `file` where `file_hash` = ?', array($hash));
        if($query){
            if($result = $query->result()){
                $ret = $result[0];
            }
        }
        return $ret;
    }

    public function get_last_file(){
        $ret = false;
        $query = $this->db->query('select max(`id`) \'id\'  from `file` ');
        if($query){
            $temp_arr = $query->result();
            $file_id = $temp_arr[0]->id;
            $query = $this->get_file_by_id($file_id);
            if($query){
                $result = $query->result();
                if($result){
                    $ret = $result[0];
                }
            }
        }
        return $ret;
    }
}
