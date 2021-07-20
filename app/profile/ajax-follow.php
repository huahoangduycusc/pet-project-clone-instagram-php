<?php
sleep(1);
define('IN_SITE',true);
$rootpath = "../../";
require_once($rootpath."libs/core.php");
$result = array();
if($id){
    $account = new Account();
    $result['data'] = $account->follow($id);
    $result['count'] = $account->countFollower($id);
}
die(json_encode($result));
?>
