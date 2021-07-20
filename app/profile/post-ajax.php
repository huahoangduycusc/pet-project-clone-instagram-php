<?php
define('IN_SITE', true);
$rootpath = '../../';
require_once($rootpath . 'libs/core.php');
sleep(2);
$error = array();
$error['error'] = '';
$total = count($_FILES['filePhoto']['name']);
$message = input_post('message');
$allowExtension = array("jpeg", "jpg", "png");
if (empty($message)) {
  $error['error'] = 'Please, enter the message !';
} else {
  $data = array(
    'post_msg' => $message,
    'account_id' => $user_id,
    'post_date' => time(),
    'post_report' => '0',
    'post_private' => '0'
  );
  db_insert($T_POST, $data);
  $dirPath = "public/post/";
  $rid = db_get_insert_id();
  // Loop through each file
  for ($i = 0; $i < $total; $i++) {
    //Get the temp file path
    $tmpFilePath = $_FILES['filePhoto']['tmp_name'][$i];
    $fileName = $_FILES['filePhoto']['name'][$i];
    if ($fileName != "") {
      $ext = pathinfo($fileName, PATHINFO_EXTENSION); // extension
      if (in_array($ext, $allowExtension)) {
        $distinct = time() + $i;
        $newFilePath = "public/post/" . $distinct . "." . $ext;
        //Upload the file
        move_uploaded_file($tmpFilePath, $rootpath . $newFilePath);
        $data = array(
          'image_path' => $newFilePath,
          'post_id' => $rid
        );
        db_insert($T_POST_IMAGES, $data);
      }
    }
  }
}
die(json_encode($error));
