<?php
define('IN_SITE',true);
$rootpath = "";
require("libs/core.php");
session_destroy();
redirect($homeurl);
?>