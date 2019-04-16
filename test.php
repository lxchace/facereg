<?php

require_once 'AipFace.php';
require_once 'cutpic.php';

// 你的 APPID AK SK
const APP_ID = '14324056';
const API_KEY = 'GrPGu924LoZyTTCRyi6e0Y6g';
const SECRET_KEY = 'fponTc1ZjusHQgayWcnzEvPTrGTxTAvt';

$client = new AipFace(APP_ID, API_KEY, SECRET_KEY);

// //$image = base64_encode(file_get_contents("faceimage/hc.jpg"));
// //$imageType = "BASE64";
// //print_r($image);

// // 调用人脸检测
// //print_r($client->detect($image, $imageType));

$source = 'img/bg.jpg';//原图片名称
$dst_img = 'img/bg.jpg';//压缩后图片的名称
$percent = 0.5; #原图压缩，不缩放，但体积大大降低
$image = (new imgcompress($source,$percent))->compressImg($dst_img);

// $result = $client->match(array(
//     array(
//         'image' => base64_encode(file_get_contents("faceimage/czy.jpg")),
//         'image_type' => 'BASE64',
//     ),
//     array(
//         'image' => base64_encode(file_get_contents('faceimage/czy2.jpg')),
//         'image_type' => 'BASE64',
//     ),
// ));

// $result = $client->search(base64_encode(file_get_contents("faces/hc3.jpg")), "BASE64", "default",array("liveness_control"=>"HIGH"));

// print_r($result);


// require_once 'mysql.class.php';
// /* 连接数据库 */

// $mysql = new mysql();
// $mysql->connect();

// function getImg(){
//     global $mysql ;
//     $sql = 'SELECT img FROM iot_needcheck WHERE ID=6';
//     $mysql->querySQL($sql);
//     print_r($mysql->fetchAll());
//     return $mysql->fetchAll()[0]['img'];
// }
// getImg();

?>