<?php
define('IN_SITE',true);
$rootpath = "";
require("libs/core.php");
if($user_id){
    redirect($homeurl);
}
$error = array();
if(isset($_POST['signin'])){
    $username = input_post('username');
    $password = input_post('password');
    $token = input_post('token');
    if(empty($username)){
        $error['username'] = 'Username cannot be blank';
    }
    if(empty($password)){
        $error['password'] = 'Password cannot be blank';
    }
    if(CSRF::validate_token($token) == false){
        $error['token'] = 'Request is not valid';
    }
    if(empty($error)){
        $account = new Account();
        if($account->checkIfExists($username)){
           if(!$account->checkLogin($username,$password)){
            $error['username'] = 'These credentials is not match any our record';
           }
           else{
               $_SESSION['uid'] = $account->account_id;
               redirect($homeurl);
           }
        }
        else{
            $error['username'] = 'These credentials is not match any our record';
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
                    <form method="post">
                        <?php showError($error,'username'); ?>
                        <div class="txt-input">
                            <label>Username or email</label>
                            <input type="text" name="username" id="username" value="<?php oldInput('username');?>">
                        </div>
                        <?php showError($error,'password'); ?>
                        <div class="txt-input">
                            <label>Password</label>
                            <input type="password" name="password" id="password" value="<?php oldInput('password');?>">
                        </div>
                        <?php CSRF::create_token();?>
                        <?php showError($error,'token'); ?>
                        <div class="txt-button">
                            <button type="submit" name="signin" value="signin">Sign in</button>
                        </div>
                    </form>
                </div>
                <!-- list1  -->
                <div class="list1">
                    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
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