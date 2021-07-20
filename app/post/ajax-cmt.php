<?php
sleep(1);
define('IN_SITE',true);
$rootpath = "../../";
require_once($rootpath."libs/core.php");
$result = array();
$id = input_post('id');
$msg = input_post('msg');
if($id && strlen($msg) > 1){
    $post = new Post();
    $result['data'] = $post->commentAct($id,$msg);
}
die(json_encode($result));
?>
