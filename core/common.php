<?php
/**
 * 一些常用的函数功能
 *
 */

function init(){
    define('MODEL_PATH', APP_PATH.'models'.DIRECTORY_SEPARATOR);
    define('CONTROLLER_PATH', APP_PATH.'controllers'.DIRECTORY_SEPARATOR);
    define('VIEW_PATH', APP_PATH.'views'.DIRECTORY_SEPARATOR);
    define('TEMPLATE_PATH', APP_PATH.'template'.DIRECTORY_SEPARATOR);
    define('LIBRARY_PATH', APP_PATH.'libraries'.DIRECTORY_SEPARATOR);
    define('EVENT_PATH', APP_PATH.'events'.DIRECTORY_SEPARATOR);
    define('CONFIG_PATH', APP_PATH.'config'.DIRECTORY_SEPARATOR);

    require CORE_PATH.'framework.php';
    require CORE_PATH.'registry.php';

    set_error_handler('error_handler');
    //error_reporting(E_ALL & ~E_NOTICE);
    ini_set ("error_log" , LOG_PATH.'phperror_'.date('Y-m-d').'.txt');
}

function quit(){
    $errormsg = Registry::get('errormsg');
    if ($errormsg) {
        log_message($errormsg);
    }
}

function error_handler($errno, $errstr, $errfile, $errline) {
	if( E_NOTICE == $errno) return;
	
    $err = "[$errno] $errstr<br /> $errline in file $errfile \n <br />";
    log_message($err);
    return true;
}

function genguid() {
    $sessionguid= com_create_guid();
    //change to stringreplace
    return substr($sessionguid, 1, 8).substr($sessionguid, 10, 4).substr($sessionguid,15, 4).substr($sessionguid,20, 4).substr($sessionguid,25,12);
}

function log_message($message) {
    $username = Registry::get('selfusername');
    $filename = $username?(LOG_PATH.$username.'_'.date('Y-m-d').'.txt'):(LOG_PATH.'common'.'_'.date('Y-m-d').'.txt');
    $file = fopen($filename, 'ab');
    if (is_array($message)){
        fwrite($file, date('Y-m-d H:i:s'). print_r($message, true)." \n");
    }
    else{
        fwrite($file, date('Y-m-d H:i:s')." {$message} \n");
    }    
    fclose($file);
    return true;
}

function cryptstring($string, $ise) {

    $key = md5(md5('a550fahEcOY74hnw'));
    $key_length = strlen($key);

    $string = $ise ? substr(md5($string.$key), 0, 8).$string : base64_decode($string);
    $string_length = strlen($string);

    $rndkey = $box = array();
    $result = '';

    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($key[$i % $key_length]);
        $box[$i] = $i;
    }
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($ise) {
        return str_replace('=', '', base64_encode($result));
    } else {
        if(substr($result, 0, 8) == substr(md5(substr($result, 8).$key), 0, 8)) {
            return substr($result, 8);
        } else {
            return '';
        }
    }
}

?>