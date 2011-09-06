<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NDownload extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('File_model', '', true);
        $this->load->model('Token_model', '', true);
        $this->load->model('Download_key_model', '', true);
    }

    function index(){
        $return_value = array();
        $return_value['error'] = true;
        $return_value['err_msg'] = 'No direct access, please.';

        $ret = json_encode($return_value);

        echo $ret;
    }

    function handle(){
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $this->fetch();
    }

    private function check_token(){
        $token = $this->input->post('token');
        $code = $this->input->post('code');
        if($token && $code){
            $token = base64_decode($token);
            $token_obj = $this->Token_model->get_token($code);

            $is_valid = false;
            if($token){
                $key = $token_obj->key;
                $token_verifying = CryptTool::decrypt($key, $token);
                if($token_verifying == $token_obj->token){
                    $is_valid = true;
                }
            }
        }
    }

    private function fetch(){
        $fetch_hash = !empty($_GET['fetch_hash'])?$_GET['fetch_hash']:'';

        if (empty($fetch_hash)) {
            $return_values['error'] = true;
            $return_values['err_msg'] = 'no fetch_hash specified!';
            $ret = json_encode($return_values);
            echo $ret;
        }
        else {
            $file_query = $this->File_model->get_file($fetch_hash);
            $root_path = $this->config->item('file_path');
            $seperator = $this->config->item('dir_seperator');
            if($result = $file_query->result()){
                $file_path = $root_path.$seperator.$result[0]->full_path;
                $file_type = $result[0]->mime_type;
                $expire=180;
                $filename = $result[0]->name; 
                $length = filesize($file_path);

                $file_info = array(
                    "name" => $result[0]->name,
                    "type" => $result[0]->mime_type,
                    "size" => filesize($file_path),
                    "path" => $file_path
                );

                /* send the file */
                FileTool::send_file($file_info);
            }
            else{
                $return_values['error'] = true;
                $return_values['err_msg'] = 'No file match the hash';

                $ret = json_encode($return_values);
                echo $ret;
            }
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
