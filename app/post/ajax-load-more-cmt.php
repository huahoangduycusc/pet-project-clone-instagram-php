<?php
sleep(1);
define('IN_SITE',true);
$rootpath = "../../";
require_once($rootpath."libs/core.php");
$result = array();
$id = input_post('id');
$skip = input_post('skip');
$skip = abs(intval($skip));
$start = $skip;
if($id){
    $post = new Post();
    $loops = $post->getComments($id);
    foreach($loops as $cmt){
        $cmt['cmt_date'] = thoigian($cmt['cmt_date']);
    }
    $result['data'] = $loops;
}
die(json_encode($result));
?>
