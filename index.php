<?php
define("VERSION", "201200614");
define("ROOT_PATH",dirname(__FILE__));
define('CORE_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR);
define('APP_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR);
define('LOG_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR);
define('Db_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR);
define('APP_URL','http://'.$_SERVER['SERVER_NAME'].'/');
date_default_timezone_set("Asia/Shanghai");
require CORE_PATH.'common.php';
init();
$actiontype=array_key_exists('action', $_GET)?$_GET['action']:(array_key_exists('action', $_POST)?$_POST['action']:'index');
error_reporting(E_ALL);
ini_set("display_errors", 1);
if(!$actiontype)
{
    exit;
}
$controlers = array(
    'index'=>'blog',
    'create'=>'blog',
    'edit'=>'blog',
    'delete'=>'blog',
    'search'=>'blog',
    'show'=>'blog'
  );

if(!array_key_exists($actiontype, $controlers))
{
     print_r(json_encode(array("tip"=>-1)));
     exit;
}

unset($_GET["action"]);
unset($_POST["action"]);

$framework = FrameWork::instance();
//$framework->registerevents(array('auth_device'),array('output_device'));
$framework->run($controlers[$actiontype],$actiontype.'Action',array_values($_POST));

quit();
?>
