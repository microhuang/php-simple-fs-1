<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

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

    function submit(){
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
                /* file proccess */
                /* return values */
                $root_path = $this->config->item('file_path');
                $dir_name = 'test';

                $return_values = array();

                $token = $this->input->post('access_token');

                $dir_tool = new DirTool();

                $files = $_FILES;
                if($files){
                    $dir_tool_obj = new DirTool();
                    $saved_url = array();
                    foreach($files as $file){
                        /* save the file */
                        $save_path = $this->config->item('save_path');
                        $seperator = $this->config->item('dir_seperator');
                        $save_path .= date("Y").$seperator.date("m").$seperator.date("d").$seperator.$file['name'];
                        $flag = move_uploaded_file($save_path, $file['tmp_name']);

                        /* insert file info */
                        $inputarr = array();
                        $inputarr['name'] = $file['name'];
                        $inputarr['mime_type'] = $file['type'];
                        $inputarr['size'] = $file['size'];

                        $result = $this->File_model->insert_file($inputarr);
                        $last_file = $this->File_model->get_last_file();

                        /* set file url */
                        $saved_url[] = array(
                            "id" => $last_file[0]->id,
                            "url" =>  $last_file[0]->path
                        )
                    } 
                    
                    $return_values['error'] = false;
                    $return_values['err_msg'] = '';
                    $return_values['saved_file'] = $saved_url;

                    $ret = json_encode($return_values);
                    echo $ret;
                }
                else{
                    $return_values['error'] = true;
                    $return_values['err_msg'] = 'No file attached.';

                    $ret = json_encode($return_values);
                    echo $ret;
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
