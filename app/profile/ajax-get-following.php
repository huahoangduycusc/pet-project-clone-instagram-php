<?php
sleep(1);
define('IN_SITE',true);
$rootpath = "../../";
require_once($rootpath."libs/core.php");
$result = array();
$start = ($page*$limit)-$limit;
$html = "";
if($id){
    $account = new Account();
    $list = $account->getFollowing($id);
    foreach($list as $obj){
        $textFollow = $account->isFollowed($obj['to_account']) ? 'Unfollow' : 'Follow';
        $html .='<li class="any-item">
        <div class="any-item-avatar">
            <a href="'.Account::Url($obj['to_account']).'"><img src="'.$homeurl.$obj['avatar'].'" alt=""></a>
        </div>
        <div class="any-item-profile">
            <div class="any-profile-user"><a href="'.Account::Url($obj['to_account']).'">'.$obj['username'].'</a></div>
            <div class="any-profile-name">'.$obj['fullname'].'</div>
        </div>
        <div class="any-item-btn '.($user_id == $obj['to_account'] ? 'hidden' : '').'">
            <button class="btn-follow-sm follow-request" data-u="'.$obj['to_account'].'">'.$textFollow.'</button>
        </div>
    </li>';
    }
    if (count($list) < $limit){
        $html .= '<script language="javascript">stopped = true; </script>';
    }
    echo $html;
}
?>
