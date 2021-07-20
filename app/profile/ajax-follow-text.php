<?php
define('IN_SITE',true);
$rootpath = "../../";
require_once($rootpath."libs/core.php");
$result = array();
if($id){
    $account = new Account();
    $result['data'] = $account->isFollowed($id);
}
die(json_encode($result));
?>
