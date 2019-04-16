<?php
require_once 'core.php';

if(!empty($_GET['action'])){
    $action=$_GET['action'];
}else{
    $action=NULL;
}
if($action=="del"){
    $result = deluser(getUserSID($_GET["id"]));
    if($result['error_code']==0){
        delpic($_GET["id"]);
        echo "<script>alert('删除成功!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>"; 
    }else{
        echo "<script>alert('".$result['error_msg']."');</script>";
        echo "<script>alert('删除失败啦~');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
    }
}else{
    delpic($_GET["id"]);
    echo "<script>alert('删除成功!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
}

function delpic($ID){
    global $mysql ;
    $where = 'ID = '.$ID;
    $mysql->delete($table = 'iot_user', $where);
    return;
}