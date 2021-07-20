<?php
// store connect
$con = null;
// connect function
function db_connect(){
    global $con;
    if(!$con){
        $con = mysqli_connect('localhost','root','','instagram')
        or die('Cannot connect to database !');
        mysqli_set_charset($con, 'UTF8');
        $con->set_charset('utf8mb4');
    }
}
// disconnect function
function db_close(){
    global $con;
    if($con){
        mysqli_close($con);
    }
}
// get list of records and assign in array
function db_get_list($sql){
    db_connect();
    global $con;
    $data = array();
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    return $data;
}
// get one record
function db_get_row($sql){
    db_connect();
    global $con;
    $result = mysqli_query($con,$sql);
    $row = array();
    if($result){
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
        }
    }
    return $row;
}
// function execute sql statement
function db_execute($sql){
    db_connect();
    global $con;
    $result = mysqli_query($con,$sql) or die(mysqli_error($con));
    return $result;
}
// insert table
function db_insert($table, $data = array()){
    // hai biến danh sách field và value
    $fields = '';
    $values = '';
    // lặp mảng dữ liệu để nối chuỗi
    foreach($data as $field => $value){
        $fields .= $field.',';
        $values .= "'".Generic::secure($value)."',";
    }
    // xóa ký tự , ở cuối chuỗi
    $fields = trim($fields,',');
    $values = trim($values,',');
    // tạo câu lệnh SQL
    $sql = "INSERT INTO {$table}($fields) VALUES({$values})";
    // thực hiện insert
    return db_execute($sql);

}
// get id just insert
function db_get_insert_id(){
    db_connect();
    global $con;
    $id = mysqli_insert_id($con);
    return $id;
}
// where sql
function db_create_sql($sql,$filter = array()){
    // chuỗi where
    $where = '';
    // lặp qua biến filter và bổ xung vào where
    foreach($filter as $filed => $value){
        if($value != ''){
            $value = addslashes($value);
            $where .= "AND $filed = '$value' ";
        }
    }
    // remove and
    $where = trim($where,'AND');
    // nếu có điều kiện where thì nối chuỗi
    if($where){
        $where = ' WHERE '.$where;
    }
    // return về câu truy vấn
    return str_replace('{where}',$where,$sql);
}
// update sql
function db_update($table,$data = array(),$filter = array()){
    // sql
    $sql = '';
    //  biến danh sách fields và values
    $merge = '';
    // lặp mảng dữ liệu để nối chuỗi
    foreach($data as $field => $value){
        if($value != ''){
            $value = Generic::secure($value);
            $merge .= "`{$field}` = '{$value}',"; 
        }
    }
    // lọc điều kiên
    $where = '';
    foreach($filter as $field => $value){
        if($value != ''){
            $value = addslashes($value);
            $where .= "AND `{$field}` = '{$value}' ";
        }
    }
    // xóa chữ and
    $where = trim($where,'AND');
    // xóa ký tự , ở cuối chuỗi
    $merge = trim($merge,',');
    if($merge != '' && $where != ''){
        $sql = "UPDATE `{$table}` SET $merge WHERE $where";
    }
    return db_execute($sql);
}
// count row
function db_count($table,$column,$where = array()){
    $merge = '';
    // lặp mảng dữ liệu để nối chuỗi
    foreach($where as $field => $value){
        if($value != ''){
            $value = addslashes($value);
            $merge .= "AND `{$field}` = '{$value}' "; 
        }
    }
    // xóa chữ and
    $merge = trim($merge,'AND');
    if($merge != ''){
        $sql = "SELECT `{$column}` FROM `{$table}` WHERE $merge";
    }
    else{
        $sql = "SELECT `{$column}` FROM `{$table}`";
    }
    return mysqli_num_rows(db_execute($sql));
}
// sum row
function db_sum($table,$column,$where = array()){
    $merge = '';
    // lặp mảng dữ liệu để nối chuỗi
    foreach($where as $field => $value){
        if($value != ''){
            $value = addslashes($value);
            $merge .= "AND `{$field}` = '{$value}' ";
        }
    }
    // delete word and
    $merge = trim($merge,'AND');
    if($merge != ''){
        $sql = "SELECT SUM(`{$column}`) as 'total' FROM `{$table}` WHERE $merge";
    }
    else{
        $sql = "SELECT SUM(`{$column}`) as 'total' FROM `{$table}`";
    }
    $total = db_get_row($sql);
    return $total['total'];
}

?>