<?php
require_once "core.php";



$action = $_POST["action"];
$sql = 'SELECT `img` FROM iot_user WHERE `ID`='.$_POST["ID"];
$mysql->querySQL($sql);
$image = $mysql->fetchAll()[0]['img'];

if($action=="pass"){
    $result = adduser($image,$_POST["SID"],$_POST["Name"]);
    if($result['error_code']==0){
        $sql = 'UPDATE `iot_user` SET `Name`="'.$_POST["Name"].'",`SID`="'.$_POST["SID"].'",`Usercheck`=0 WHERE `ID`='.$_POST["ID"];
        $src = $mysql->querySQL($sql);
        echo "<script>alert('通过啦~');location.href='/index.php?act=needcheck';</script>";
    }else{
        echo "<script>alert('".$result['error_msg']."');</script>";
        echo "<script>alert('失败啦~');location.href='/index.php?act=needcheck';</script>";
    }
    
    //echo "<script>alert(".$sql.");</script>";
}else if($action=="modify"){
    $result1 = deluser($_POST["SID"]);
    //$result2 = adduser($image,$_POST["SID"],$_POST["Name"]);
    if($result1['error_code']==0){
        $sql = 'UPDATE `iot_user` SET `Name`="'.$_POST["Name"].'",`SID`="'.$_POST["SID"].'",`Usercheck`='.$_POST["Usercheck"].' WHERE `ID`='.$_POST["ID"];
        $src = $mysql->querySQL($sql);  
        if($_POST["Usercheck"]==0){
            $result2 = adduser($image,$_POST["SID"],$_POST["Name"]);//如果要变成未通过状态，则不用添加回去
            if($result2['error_code']==0){
                echo "<script>alert('修改成功啦~');location.href='/index.php?act=users';</script>";
            }else{
                echo "<script>alert('添加操作：".$result2['error_msg']."');</script>";
                echo "<script>alert('失败啦~');location.href='/index.php?act=needcheck';</script>";
            }
        }else{
            echo "<script>alert('修改成功啦~');location.href='/index.php?act=users';</script>";
        }
    }else{
        echo "<script>alert('删除操作：".$result1['error_msg']."');</script>";
        echo "<script>alert('失败啦~');location.href='/index.php?act=needcheck';</script>";
    }
}

