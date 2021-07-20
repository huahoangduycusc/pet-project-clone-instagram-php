<?php
sleep(1);
define('IN_SITE',true);
$rootpath = "../../";
require_once($rootpath."libs/core.php");
$result = array();
$id = input_post('id');
$msg = input_post('msg');
$post = new Post();
switch($do){
    case 'show':
        $editPost = $post->viewInfo($id);
        if($editPost){
            echo "<form>
            <div class='form-input'>
                <textarea class='form-control' rows='7' id='msgEdit'>".html_entity_decode($editPost['post_msg'])."</textarea>
                <button class='button btn-save-option'>Save</button>
            </div></form>";
        }
        break;
    case 'save':
        $editPost = $post->viewInfo($id);
        if($editPost){
            $result['data'] = $post->editPost($id,$msg);
        }
        die(json_encode($result));
        break;
}
?>
