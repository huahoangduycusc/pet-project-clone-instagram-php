<?php
class Post{

    public $table;
    public $post_id;
    // table relationship
    public $table_img;
    public $table_cmt;
    public $table_account;
    public $table_like;
    public $table_saved;

    public function __construct()
    {
        // get table in database
        global $T_POST;
        global $T_ACCOUNT;
        global $T_POST_IMAGES;
        global $T_POST_CMT;
        global $T_POST_LIKE;
        global $T_POST_SAVED;
        // assign to variables in class
        $this->table = $T_POST;
        $this->table_cmt = $T_POST_CMT;
        $this->table_account = $T_ACCOUNT;
        $this->table_img = $T_POST_IMAGES;
        $this->table_like = $T_POST_LIKE;
        $this->table_saved = $T_POST_SAVED;
    }
    // post url custom
    public static function Url($id){
        global $homeurl;
        return $homeurl."/app/post/view.php?id=$id";
    }
    // view post
    public function viewInfo($id){
        $id = Generic::secure($id);
        $sql = "SELECT `post_id`, `post_msg`, p.`account_id`, a.`username`, a.`avatar`, `post_date` FROM `$this->table` p
        INNER JOIN `$this->table_account` a ON p.`account_id` = a.`account_id` WHERE p.`post_id` = '{$id}' LIMIT 1";
        return db_get_row($sql);
    }
    // get post of account followed
    public function getAllPostofAccountFollowed(){
        global $start;
        global $limit;
        global $user_id;
        $sql = "SELECT `post_id`, `post_msg`, p.`account_id`, a.`username`, a.`avatar`, `post_date` FROM `$this->table` p
        INNER JOIN `$this->table_account` a ON p.`account_id` = a.`account_id` WHERE p.`account_id` = '{$user_id}' ORDER BY p.`post_id` DESC LIMIT $start,$limit";
        return db_get_list($sql);
    }
    // get more post
    public function getMorePost(){
        global $start;
        global $limit;
        $sql = "SELECT `post_id`, `post_msg`, p.`account_id`, a.`username`, a.`avatar`, `post_date` FROM `$this->table` p
        INNER JOIN `$this->table_account` a ON p.`account_id` = a.`account_id` ORDER BY p.`post_id` DESC LIMIT $start,$limit";
        return db_get_list($sql);
    }
    // get images of post
    public function getImages($idPost){
        $sql = "SELECT `image_path` FROM `$this->table_img` WHERE `post_id` = '{$idPost}' ORDER BY `post_id` ASC";
        return db_get_list($sql);
    }

    // count likes of post
    public function countLikes($id){
        return db_count($this->table_like,'like_id',array('post_id' => $id));
    }

    // check if user liked ?
    public function isLiked($id){
        global $user_id;
        $sql = "SELECT `like_id` FROM `$this->table_like` WHERE `account_id` = '{$user_id}' AND `post_id` = '{$id}'";
        return db_get_row(($sql));
    }

    // like post action
    public function likePost($id){
        global $user_id;
        $id = Generic::secure($id);
        $sql = "SELECT `like_id` FROM `$this->table_like` WHERE `account_id` = '{$user_id}' AND `post_id` = '{$id}'";
        $row = db_get_row($sql);
        if($row){
            $sql2 = "DELETE FROM `$this->table_like` WHERE `account_id` = '{$user_id}' AND `post_id` = '{$id}'";
            db_execute($sql2);
            return "unlike";
        }
        else{
            $data = array(
                'post_id' => $id,
                'account_id' => $user_id
            );
            db_insert($this->table_like,$data);
            return "like";
        }
    }
    // comment on post
    public function commentAct($id,$msg){
        global $user_id;
        if($this->viewInfo($id)){
            $data = array(
                'cmt_msg' => $msg,
                'account_id' => $user_id,
                'post_id' => $id,
                'cmt_date' => time(),
                'cmt_report' => '0'
            );
            if(db_insert($this->table_cmt,$data)){
                $comment = new Comment();
                $jsonRow = $comment->getRow(db_get_insert_id());
                $jsonRow['cmt_msg'] = html_entity_decode($jsonRow['cmt_msg']);
                $jsonRow['cmt_date'] = thoigian($jsonRow['cmt_date']);
                return $jsonRow;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    // get comment
    public function getComments($id){
        global $start;
        global $limit;
        $sql = "SELECT `cmt_id`, `cmt_msg`, c.`account_id`, `cmt_date`, `cmt_report`, a.`username`, a.`avatar`
        FROM `$this->table_cmt` c INNER JOIN `$this->table_account` a ON a.`account_id` = c.`account_id`
        WHERE `post_id` = '{$id}' ORDER BY `cmt_id` DESC LIMIT $start,$limit";
        return db_get_list($sql); 
    }
    
    /// save post
    public function savedPost($id){
        global $user_id;
        if($this->viewInfo($id)){
            $sql = "SELECT `save_id` FROM `$this->table_saved` WHERE `account_id` = '{$user_id}' AND `post_id` = '{$id}'";
            $row = db_get_row($sql);
            if($row){
                $sqlDel = "DELETE FROM `$this->table_saved` WHERE `account_id` = '{$user_id}' AND `post_id` = '{$id}'";
                db_execute($sqlDel);
                return "unsave";
            }
            else{
                $data = array(
                    'account_id' => $user_id,
                    'post_id' => $id
                );
                db_insert($this->table_saved,$data);
                return "saved";
            }
        }
        else{
            return false;
        }
    }
    // edit post
    public function editPost($id,$msg){
        global $user_id;
        $author = $this->viewInfo($id);
        if($author){
            if($author['account_id'] == $user_id){
                $data = array(
                    'post_msg' => $msg
                );
                return db_update($this->table,$data,array('post_id' => $id));
            }
            else{
                return 0;
            }
        }
        else{
            return 0;
        }
    }
    // check if user saved post before ?
    public function isSaved($id){
        global $user_id;
        $sql = "SELECT `save_id` FROM `$this->table_saved` WHERE `account_id` = '{$user_id}' AND `post_id` = '{$id}'";
        return db_get_row(($sql));
    }
    // get post of account
    public function getPostOfAccount($id,$start){
        $sql = "SELECT p.`post_id`, i.`image_path`, i.`image_id` FROM `$this->table` p LEFT JOIN `$this->table_img` i ON p.`post_id` = i.`post_id`
        WHERE p.`account_id` = '{$id}'
        GROUP BY p.`post_id` ORDER BY p.`post_id` DESC LIMIT $start,6";
        return db_get_list($sql);
    }
    // get latest post of account
    public function latestPost($id,$account_id){
        $sql = "SELECT p.`post_id`, i.`image_path`, i.`image_id` FROM `$this->table` p LEFT JOIN `$this->table_img` i ON p.`post_id` = i.`post_id`
        WHERE p.`account_id` = '{$account_id}' AND p.`post_id` != '{$id}'
        GROUP BY p.`post_id` ORDER BY p.`post_id` DESC LIMIT 6";
        return db_get_list($sql);
    }
    // get post saved of account
    public function getPostSaved($account_id,$start=0){
        global $start;
        global $limit;
        $sql = "SELECT s.`post_id`, i.`image_path`, i.`image_id` FROM `$this->table_saved` s
        INNER JOIN `$this->table_img` i 
        ON s.`post_id` = i.`post_id`
        WHERE s.`account_id` = '{$account_id}'
        GROUP BY s.`post_id` ORDER BY s.`post_id` DESC LIMIT $start,6";
        return db_get_list($sql);
    }
    // delete post
    public function delete($id){
        global $user_id;
        global $rights;
        global $rootpath;
        $post = $this->viewInfo($id);
        if($post && $post['account_id'] == $user_id){
            $sql = "DELETE FROM `$this->table` WHERE `post_id` = '{$id}'";
            $images = $this->getImages($id);
            foreach($images as $image){
                unlink("".$rootpath.$image['image_path']."");
            }
            return db_execute($sql);
        }
        else{
            return false;
        }
    }
    // report 
    public function report($id){
        global $user_id;
        $post = $this->viewInfo($id);
        if($post){
            $sql = "UPDATE `$this->table` SET `post_report` = `post_report` + '1' WHERE `post_id` = '{$id}'";
            return db_execute($sql);
        }
        else{
            return false;
        }
    }
    // explore post
    public function explore(){
        global $start;
        global $limit;
        $sql = "SELECT p.`post_id`, i.`image_path`, i.`image_id` FROM `$this->table` p LEFT JOIN `$this->table_img` i 
        ON p.`post_id` = i.`post_id`
        GROUP BY p.`post_id` ORDER BY p.`post_id` DESC LIMIT $start,$limit";
        return db_get_list($sql);
    }
}
?>