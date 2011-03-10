<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function recur_mkdirs($path, $mode = 0777) //creates directory tree recursively
{
    //$GLOBALS["dirseparator"]
    $dirs = explode($GLOBALS["dirseparator"],$path);
    $pos = strrpos($path, ".");
    if ($pos === false) { // note: three equal signs
       // not found, means path ends in a dir not file
        $subamount=0;
    }
    else {
        $subamount=1;
    }
   
    for ($c=0;$c < count($dirs) - $subamount; $c++) {
        $thispath="";
        for ($cc=0; $cc <= $c; $cc++) {
            $thispath.=$dirs[$cc].$GLOBALS["dirseparator"];
        }
        if (!file_exists($thispath)) {
            //print "$thispath<br>";
            mkdir($thispath,$mode);
        }
       
       
    }
   
}
