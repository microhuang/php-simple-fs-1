<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FileTool{
    
    static function send_file($inputarr){
        if($inputarr){
            /* the file type is accroding to the mime type, not concern on file name */
            header('Content-Description: File Transfer');
            header('Content-Type: '. $inputarr['type']); 
            // header('Content-Disposition: attachment; filename*="utf8\'\''.urlencode($inputarr['name']).'"');
             
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $filename = $inputarr['name'];
            if (stripos($user_agent, 'MSIE')) {
                $filename_header = "filename=" . iconv('utf8', 'gb18030', $filename);
            } else if (stripos($user_agent, 'safari')) {
                $filename_header = "filename={$filename}";
            } else {
                $filename_header = "filename*=UTF-8''".urlencode($filename);
            }

            header('Content-Disposition: attachment; '.$filename_header);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . $inputarr['size']);

            ob_clean();
            flush();
            readfile($inputarr['path']);
        }
    }
}
