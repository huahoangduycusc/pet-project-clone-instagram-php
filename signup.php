<?php
define('IN_SITE',true);
$rootpath = "";
require("libs/core.php");
if($user_id){
    redirect($homeurl);
}
$error = array();
if(isset($_POST['signup'])){
    $regex = "/[^a-zA-Z0-9]/";
    $email = input_post('email');
    $fullname = input_post('fullname');
    $username = input_post('username');
    $password = input_post('password');
    $token = input_post('token');
    if(empty($email)){
        $error['email'] = 'Email can not be blank';
    }
    if(empty($fullname)){
        $error['fullname'] = 'Full name can not be blank';
    }
    if(empty($username)){
        $error['username'] = 'Username can not be blank';
    }
    else if(preg_match($regex,$username)){
            $error['username'] = 'Username must not contain any special character';
    }
    else if(strlen($username) < 6 || strlen($username) > 15){
        $error['username'] = 'Length of username must be from 6 to 15 characters';
    }
    if(empty($password)){
        $error['password'] = 'Password can not be blank';
    }
    if(CSRF::validate_token($token) == false){
        $error['token'] = 'Request is not valid';
    }
    if(empty($error)){
        $account = new Account();
        if($account->checkIfExists($username)){
            $error['username'] = 'Account is already exists';
        }
    }
    if(empty($error)){
        $data = array(
            'username' => $username,
            'password' => password_hash($password,PASSWORD_DEFAULT),
            'fullname' => $fullname,
            'email' => $email,
            'address' => '',
            'phone' => '',
            'post' => '0',
            'verify' => '0',
            'bio' => '',
            'introduce' => '',
            'role' => 'member',
            'created_at' => date("Y-m-d H:m:s")
        );
        if(db_insert($T_ACCOUNT,$data)){
            $_SESSION['uid'] = db_get_insert_id();
            redirect($homeurl);

        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./theme/login.css" type="text/css">
</head>
<body>
    <div class="container">
        <main>
            <div class="box">
                <div class="list1">
                    <h1 class="title">Instagram</h1>
                    <p class="slogan">Sign up to see photos from your friends.</p>
                    <form method="post">
                        <?php showError($error,'email'); ?>
                        <div class="txt-input">
                            <label>Email</label>
                            <input type="text" name="email" id="email" type="email" value="<?php oldInput('email');?>">
                        </div>
                        <?php showError($error,'fullname'); ?>
                        <div class="txt-input">
                            <label>Full name</label>
                            <input type="text" name="fullname" id="fullname" value="<?php oldInput('fullname');?>">
                        </div>
                        <?php showError($error,'username'); ?>
                        <div class="txt-input">
                            <label>Username</label>
                            <input type="text" name="username" id="username" value="<?php oldInput('username');?>">
                        </div>
                        <?php showError($error,'password'); ?>
                        <div class="txt-input">
                            <label>Password</label>
                            <input type="password" name="password" id="password"  value="<?php oldInput('password');?>">
                        </div>
                        <?php CSRF::create_token();?>
                        <?php showError($error,'token'); ?>
                        <div class="txt-button">
                            <button type="submit" name="signup" value="<?php echo base64_encode(time());?>">Sign up</button>
                        </div>
                    </form>
                </div>
                <!-- list1  -->
                <div class="list1">
                    <p>Have an account? <a href="<?php echo $homeurl."/signin.php";?>">Sign in</a></p>
                </div>
            </div>
        </main>
        <footer class="footer">
            <p>&copy;  All Rights Reversed 2020</p>
            <span>Founded and developed by Hua Hoang Duy</span>
        </footer>
    </div>
    <script>
    const input = document.querySelectorAll('input');
    input.forEach(item => {
        if(item.value != ""){
            item.parentElement.classList.add("active");
        }
        item.addEventListener('focus',(e) => {
        item.offsetParent.classList.add('active');
        });
        item.addEventListener('blur',(e) => {
            if(e.target.value == ""){
                item.offsetParent.classList.remove('active');
            }
        });
        item.addEventListener('keyup',(e) => {
            if(e.target.value == ""){
                item.offsetParent.classList.remove('active');
            }
        });
    });
    </script>
</body>
</html>