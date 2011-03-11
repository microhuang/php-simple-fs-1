<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fetch extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('File_model', '', true);
        $this->load->model('Token_model', '', true);
    }

    function index(){
        $return_value = array();
        $return_value['error'] = true;
        $return_value['err_msg'] = 'No direct access, please.';

        $ret = json_encode($return_value);

        echo $ret;
    }

    function fetch(){
        /* verify the token */
        $token = $this->input->post('token');
        $key = $this->input->post('key');
        if($token && $key){
            $crypt_tool_obj = new CryptTool();
            $token = $crypt_tool_obj->decrypt($key, $token);
            $token_query = $this->Token_model->is_valid($token);

            if($result = $token_query->result()){
                foreach($result as $token_obj){
                    $is_valid = true;
                    $key = $token_obj->key;
                }
            }

            if($is_valid){
                $file_id = $this->input->post('id');
                $file_query = $this->File_model->get_file($file_id);
                if($result = $file_query->result()){
                    $file_path $result[0]->path;
                }
            }
            else{
                $return_values['error'] = true;
                $return_values['err_msg'] = 'Not a valid token.';

                $ret = json_encode($return_values);
                echo $ret;
            }
        }
        else{
            $return_values['error'] = true;
            $return_values['err_msg'] = 'Token or key missing.';

            $ret = json_encode($return_values);
            echo $ret;
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
