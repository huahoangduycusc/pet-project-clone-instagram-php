<?php
define('IN_SITE',true);
$rootpath = "../../";
require_once($rootpath."libs/core.php");
$result = array();
if($id){
    $post = new Post();
    $result['data'] = $post->likePost($id);
    $result['countLike'] = $post->countLikes($id);
}
die(json_encode($result));
?>
