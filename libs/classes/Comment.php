<?php
class Comment{

    // khai bao bang
    public $table;
    public $tb_account;

    public function __construct()
    {
        global $T_POST_CMT;
        global $T_ACCOUNT;
        $this->table = $T_POST_CMT;
        $this->tb_account = $T_ACCOUNT;
    }
    // get info of comment

    public function getRow($id){
        $sql = "SELECT `cmt_id`,`cmt_msg`,c.`account_id`,a.`username`,a.`avatar`,`post_id`,`cmt_date`,`cmt_report`
        FROM `$this->table` c INNER JOIN `$this->tb_account` a
        ON c.`account_id` = a.`account_id` WHERE `cmt_id` = '{$id}'";
        return db_get_row($sql);
    }

}
?>