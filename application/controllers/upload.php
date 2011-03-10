<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('File_model', '', true);
	}

	function index(){
        $return_value = array();
        $return_value['error'] = true;
        $return_value['err_msg'] = 'No direct access, please.';

        $ret = json_encode($return_value);

        echo $ret;
	}

    function submit(){
        /* return values */
        $root_path = $this->config->item('file_path');
        $dir_name = 'test';

        $return_values = array();

        $token = $this->input->post('access_token');

        $files = $_FILES;
        if($files){
            foreach($files as $file){
                

                $inputarr = array();
                $inputarr['name'] = $file['name'];
                $inputarr['mime_type'] = $file['type'];
                $inputarr['size'] = $file['size'];

                //$result = $this->File_model->insert_file($inputarr);
                // print_r($result);
            } 
        }
        else{
            $return_values['error'] = true;
            $return_values['err_msg'] = 'No file attached.';
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
