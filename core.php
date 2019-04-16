<?php
require_once 'mysql.class.php';
require_once 'AipFace.php';
require_once 'cutpic.php';
/* 连接数据库 */
$mysql = new mysql();
$mysql->connect();

// 你的 APPID AK SK
const APP_ID = '';
const API_KEY = '';
const SECRET_KEY = '';

$client = new AipFace(APP_ID, API_KEY, SECRET_KEY);

function getUserName($SID){
    global $mysql ;
    $sql = 'SELECT Name FROM iot_user WHERE SID='.$SID;
    $mysql->querySQL($sql);
    //print_r($mysql->fetchAll());
    return $mysql->fetchAll()[0]['Name'];
}

function getUserSID($ID){
    global $mysql ;
    $sql = 'SELECT SID FROM iot_user WHERE ID='.$ID;
    $mysql->querySQL($sql);
    //print_r($mysql->fetchAll());
    return $mysql->fetchAll()[0]['SID'];
}

function cutPic($image){
    while(filesize($image)/1024>512){
        $source = $image;//原图片名称
        $dst_img = $image;//压缩后图片的名称
        $percent = 0.9; #原图压缩，不缩放，但体积大大降低
        $image = (new imgcompress($source,$percent))->compressImg($dst_img);
        $image = $dst_img;
        clearstatcache();
    }
    //var_dump($dst_img);
    //var_dump(filesize($dst_img));
    return true;
}

function getfile(){
    header('Access-Control-Allow-Origin:*');
    $image = $_FILES['image'];
    if($image['error'] == 0){
        $type = strrchr($image['name'], '.');//截取文件后缀名
        $path = "./faces/" . $image['name']; 
        if (strtolower($type) == '.png' || strtolower($type) == '.jpg' || strtolower($type) == '.bmp' || strtolower($type) == '.gif') {
            //将图片文件移到该目录下
            move_uploaded_file($image['tmp_name'], $path);
            //var_dump($path);
            cutPic($path);
        }else{
            return array('error_code' => 1,'msg' => '上传文件格式错误！');
        }
    }else{
        return array('error_code' => 1,'msg' => '上传文件失败！');
    }
    return array('error_code' => 0,'msg' => '上传文件成功！','path' => $path);;
}//负责签到头像采集

function adduser($image,$SID,$Name){
    global $client;
    $options = array("liveness_control"=>"HIGH", "liveness_control"=>"NORMAL", "user_info"=>$Name);
    $result = $client->addUser(base64_encode(file_get_contents($image)), "BASE64", "default", $SID, $options);
    return $result;
}//API中添加用户

function deluser($SID){
    global $client;
    $result = $client->deleteUser("default", $SID);
    return $result;
}//API中删除用户