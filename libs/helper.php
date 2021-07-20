<?php
// get method
$id = isset($_GET['id']) ? abs(intval($_GET['id'])) : false;
$do = isset($_GET['do']) ? trim(htmlspecialchars($_GET['do'])) : false;
$homeurl = 'http://localhost/instagram';
// create url
function homeurl($url = ''){
    global $homeurl;
    return $homeurl.$url;
}
// redirect
function redirect($url){
    header("Location:{$url}");
    exit();
}
// get value from POST
function input_post($key){
    return isset($_POST[$key]) ? htmlspecialchars($_POST[$key],ENT_QUOTES) : false;
}
// get value from GET
function input_get($key){
    return isset($_GET[$key]) ? abs(intval(trim($_GET[$key]))) : false;
}
// show error
function showError($error,$key){
    echo '<div class="text-danger">'.(empty($error[$key]) ? "" : $error[$key]).'</div>';
}
// show old value input submit action
function oldInput($fieldName){
    if(isset($_POST[$fieldName])){
        echo $_POST[$fieldName];
    }
}
// get user name
function nick($id){
    $sql = "SELECT `a_username` FROM `account` WHERE `account_id` = '{$id}' LIMIT 1";
    $out = "N/A";
    if($row = db_get_row($sql)){
        $out = $row['a_username'];
    }
    return $out;
}
// gender
function gender($type){
    $out = '';
    if($type == 1){
        $out = 'Nam';
    }
    else if($type == 2){
        $out = 'Nữ';
    }
    else{
        $out = 'Không xác định';
    }
    return $out;
}
// random string
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#$!-?@=&';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function imageResize($imageSrc,$imageWidth,$imageHeight) {

    $newImageWidth =200;
    $newImageHeight =200;

    $newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
    imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);

    return $newImageLayer;
}
?>