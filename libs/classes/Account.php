<?php
class Account{
    public $table;
    public $table_follow;
    public $account_id = '';


    public function __construct()
    {
        // call global variables
        global $T_ACCOUNT;
        global $T_ACCOUNT_FOLLOW;
        // set value
        $this->table = $T_ACCOUNT;
        $this->table_follow = $T_ACCOUNT_FOLLOW;
    }

    public static function Url($id){
        global $homeurl;
        return $homeurl."/app/profile/index.php?id=$id";
    }

    // get info of account
    public function getRow($id){
        $id = Generic::secure($id);
        $sql = "SELECT `account_id`,`username`,`fullname`,`email`,`address`,`phone`,`post`,`verify`,`bio`,`introduce`,`avatar`
        FROM `$this->table` WHERE `account_id` = '{$id}' LIMIT 1";
        return db_get_row($sql);
    }
    // check if user exists
    public function checkIfExists($username){
        $username = Generic::secure($username);
        return db_count($this->table,'account_id',array('username' => $username));
    }
    public function checkLogin($username,$password){
        $username = Generic::secure($username);
        $password = Generic::secure($password);
        $sql = "SELECT `account_id`,`username`,`password` FROM `$this->table` WHERE `username` = '{$username}' LIMIT 1";
        $row = db_get_row($sql);
        if(password_verify($password,$row['password']) == false){
            return false;
        }
        $this->account_id = $row['account_id'];
        return true;
    }
    // count follower of account
    public function countFollower($id){
        $filter = array(
            'to_account' => $id
        );
        return db_count($this->table_follow,'follow_id',$filter);
    }
    // count following
    public function countFollowing($id){
        $filter = array(
            'from_account' => $id
        );
        return db_count($this->table_follow,'follow_id',$filter);
    }
    // check if followed ?
    public function isFollowed($id){
        global $user_id;
        $filter = array(
            'from_account' => $user_id,
            'to_account' => $id
        );
        return db_count($this->table_follow,'follow_id',$filter);
    }
    // follow account
    public function follow($id){
        global $user_id;
        if($this->isFollowed($id) == 1){
            $sql = "DELETE FROM `$this->table_follow` WHERE `from_account` = '{$user_id}' AND `to_account` = '{$id}'";
            db_execute($sql);
            return "Follow";
        }
        else{
            $data = array(
                'from_account' => $user_id,
                'to_account' => $id
            );
            db_insert($this->table_follow,$data);
            return "Unfollow";
        }
    }
    // get list followers
    public function getFollowers($id){
        global $start;
        global $limit;
        $account = $this->getRow($id);
        if($account){
            $sql = "SELECT f.`from_account`, a.`username`, a.`avatar`, a.`fullname`
            FROM `$this->table_follow` f INNER JOIN `$this->table` a ON f.`from_account` = a.`account_id`
            WHERE f.`to_account` = '{$id}' ORDER BY `follow_id` DESC LIMIT $start,$limit";
            return db_get_list($sql);
        }
    }
    // get list following
    public function getFollowing($id){
        global $start;
        global $limit;
        $account = $this->getRow($id);
        if($account){
            $sql = "SELECT f.`to_account`, a.`username`, a.`avatar`, a.`fullname`
            FROM `$this->table_follow` f INNER JOIN `$this->table` a ON f.`to_account` = a.`account_id`
            WHERE f.`from_account` = '{$id}' ORDER BY `follow_id` DESC LIMIT $start,$limit";
            return db_get_list($sql);
        }
    }

    // suggestion random
    public function getSuggestion(){
        global $user_id;
        $sql = "SELECT `account_id`, `username`, `fullname`, `avatar` FROM `$this->table` ORDER by RAND() LIMIT 10";
        return db_get_list($sql);
    }

    // search for account
    public function searching($s){
        global $user_id;
        $sql = "SELECT `account_id`, `username`, `fullname`, `avatar` FROM `$this->table` WHERE `username` LIKE '%$s%' LIMIT 10";
        return db_get_list($sql);
    }

}
?>