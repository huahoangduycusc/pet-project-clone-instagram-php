<?php
class CSRF{
    public static function create_token(){
        // generate token
        $token = md5(time());
        // save in session
        $_SESSION["token"] = $token;
        // create hidden filed
        echo "<input type='hidden' name='token' value='$token' id='token'>";
    }
    public static function validate_token($token){
        // validate token
        return isset($_SESSION["token"]) && $_SESSION["token"] == $token;
    }
}
?>