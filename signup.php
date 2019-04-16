<?php
require_once "core.php";

function signup(){
    global $mysql;
    global $client;
    $face = getfile();
    if($face['error_code']==0){
        $result = $client->search(base64_encode(file_get_contents($face['path'])), "BASE64", "default",array("liveness_control"=>"HIGH"));
        //var_dump($result);
        if($result['error_code']==0){
            if($result['result']['user_list'][0]['score']>80){
                $data = array(
                    'SID'=>$result['result']['user_list'][0]['user_id']
                    );
                if($mysql->insert('iot_signup', $data)){
                    return array('error_code' => 0,'msg' => $data['SID'].',签到成功啦~');
                }
                return array('error_code' => 1,'msg' => '数据库插入错误~');
            }
        }
        return array('error_code' => 1,'msg' => $result['error_msg']);
    }
    return array('error_code' => 1,'msg' => '人脸上传失败哦~');
}

echo json_encode(signup());