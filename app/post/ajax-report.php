<?php
define('IN_SITE',true);
$rootpath = "../../";
require_once($rootpath."libs/core.php");
$result = array();
if($id){
    $post = new Post();
    $result['data'] = $post->report($id);
}
die(json_encode($result));
?>
