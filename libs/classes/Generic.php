<?php
class Generic{
    public static function secure($string){
        global $con;
        db_connect();
        $string = trim($string);
        $string = mysqli_real_escape_string($con,$string);
        $string = htmlspecialchars($string, ENT_QUOTES);
	    $string = stripslashes($string);
	    return $string;
    }
}
?>