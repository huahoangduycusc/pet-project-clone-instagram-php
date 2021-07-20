<?php
if(!defined('IN_SITE')) die('Error: restricted access');
// timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');
// start session
session_start();
$rootpath = isset($rootpath) ? $rootpath : '../';
// title website
$title = 'Mạng xã hội';
$page = isset($_GET['page']) ? abs(intval($_GET['page'])) : 1;
// limit
$limit = 10;
$start = abs(intval($limit*$page)-$limit);
// include file
include_once('helper.php');
include_once('database.php');
include_once('function.php');
include_once('tables.php');

// autoload class
spl_autoload_register('autoload');
function autoload($name){
    global $rootpath;
    $file = $rootpath.'libs/classes/'.$name.'.php';
    if(file_exists($file)){
        require_once($file);
    }
}
// authorize
$core = new Core() or die('Error: Core System');
unset($core);
$user_id = Core::$account_id;
$datauser = Core::$get_user;
$rights = Core::$rights;
$title = "Instagram";
?>