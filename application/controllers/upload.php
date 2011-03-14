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
        $code = $this->input->post('code');
        // $token = true;
        // $code = true;
        if($token && $code){
            $token_obj = $this->Token_model->get_token($code);

            $is_valid = false;
            if($token_obj){
                $key = $token_obj->key;
                $token = base64_decode($token);
                $token_verifying = CryptTool::decrypt($key, $token);
                if($token_verifying == $token_obj->token){
                    $is_valid = true;
                    $dir_name = $token_obj->dir_name;
                }
                else{
                    $return_values = array(
                        "error" => true,
                        "err_msg" => "Token doesn't match the code provided."
                    );

                    $ret = json_encode($return_values);
                    return $ret;
                }
            }

            if($is_valid){
                /* file proccess */
                $seperator = $this->config->item('dir_seperator');
                /* return values */
                $root_path = $this->config->item('file_path');

                $return_values = array();

                $dir_tool = new DirTool();
                $files = $_FILES;
                if($files){
                    $dir_tool_obj = new DirTool();
                    $saved_url = array();
                    foreach($files as $file){
                        /* save the file */
                        $save_path = $root_path.$seperator.$dir_name.$seperator.date("Y").$seperator.date("m").$seperator.date("d").$seperator;
                        $seperator = $this->config->item('dir_seperator');
                        $filename = date("H:i:s")."_".$file['name'];
                        $save_full_path = $save_path.$filename;
                        $flag = DirTool::recur_mkdir($save_path);

                        // $hash_sum = sha1_file($save_full_path);
                        $hash_sum = sha1_file($file['tmp_name']);
                        
                        /* check if identical file exist */
                        $check_file = $this->File_model->get_file_by_file_hash($hash_sum);
                        if($check_file){
                            $save_full_path = $check_file->full_path;
                        }
                        else{
                            $flag = move_uploaded_file($file['tmp_name'], $save_full_path);
                        }

                        /* insert file info */
                        $inputarr = array();
                        $inputarr['name'] = $file['name'];
                        $inputarr['mime_type'] = $file['type'];
                        $inputarr['size'] = $file['size'];
                        $inputarr['file_hash'] = $hash_sum;
                        $inputarr['fetch_hash'] = CryptTool::get_file_fetch_hash($filename);
                        $inputarr['full_path'] = $save_full_path;

                        $file_obj = $this->File_model->insert_file($inputarr);

                        /* set file url */
                        $saved_url[] = array(
                            "hash" =>  $file_obj->fetch_hash
                        );
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
