<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FileTool{
    
    static function send_file($inputarr){
        if($inputarr){
            /* the file type is accroding to the mime type, not concern on file name */
            header('Content-Description: File Transfer');
            header('Content-Type: '. $inputarr['type']); 
            header('Content-Disposition: attachment; filename*="utf8\'\''.urlencode($inputarr['name']).'"');
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
