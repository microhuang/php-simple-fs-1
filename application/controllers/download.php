<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download extends CI_Controller {

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
        if(isset($_GET['download_key'])){
            $download_key = $_GET['download_key'];
        }
        else{
            $download_key = '';
        }
        if($download_key){
            $this->fetch($download_key);
        }
        else{
            $this->verify();
        }
    }

    function verify(){
        /* verify the token */
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

            if($is_valid){
                $download_key = $this->Download_key_model->generate_key();
                $return_values['error'] = false;
                $return_values['download_key'] = $download_key;

                $ret = json_encode($return_values);
                echo $ret;
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


    private function fetch($download_key){
        $fetch_hash = $_GET['fetch_hash']?$_GET['fetch_hash']:'';
        
        $flag = $this->Download_key_model->is_valid($download_key);
        if($flag){
            $file_query = $this->File_model->get_file($fetch_hash);
            if($result = $file_query->result()){
                $file_path = $result[0]->full_path;
                $file_type = $result[0]->mime_type;
                $expire=180;
                $filename = $result[0]->name; 
                $length = filesize($file_path);

                $file_info = array(
                    "name" => $result[0]->name,
                    "type" => $result[0]->mime_type,
                    "size" => filesize($result[0]->full_path),
                    "path" => $result[0]->full_path
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
        else{
            $return_values['error'] = true;
            $return_values['err_msg'] = 'Invalid download key';

            $ret = json_encode($return_values);
            echo $ret;
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
