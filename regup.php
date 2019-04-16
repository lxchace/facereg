<?php
require_once "core.php";

function regup(){
    header('Access-Control-Allow-Origin:*');
    global $mysql;
    global $client;
    $face = getfile()['path'];
    $SID = $_POST['SID'];
    $Name = $_POST['Name'];
    
    if(empty($face)||empty($SID)||empty($Name)){
        return array('error_code'=>1, 'msg' => '用户信息上传失败！');
    }
    
    $sql = 'INSERT INTO `iot_user`(`Name`, `SID`, `img`) VALUES ("'.$Name.'","'.$SID.'","'.$face.'")';
    $mysql->querySQL($sql);
    return array('error_code' => 0, 'msg' => '用户信息上传成功啦~');
    //return array('error_code'=>1, 'msg' => '用户信息上传失败！');
}

echo json_encode(regup());