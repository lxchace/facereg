<?php
require_once 'core.php';

function getUserNum(){
    global $mysql ;
    $sql = 'SELECT * FROM `iot_user` WHERE `Usercheck`=0';
    $num = $mysql->querySQL($sql)->num_rows;
    return $num;
}

function getSignNum(){
    global $mysql ;
    $sql = 'SELECT DISTINCT SID FROM `iot_signup`';
    $num = $mysql->querySQL($sql)->num_rows;
    return $num;
}

function getCheckNum(){
    global $mysql ;
    $sql = 'SELECT * FROM `iot_user` WHERE `Usercheck`=1';
    $num = $mysql->querySQL($sql)->num_rows;
    return $num;
}

function getSignRecord(){
    global $mysql;
    if(!empty($_GET['tj'])&&!empty($_GET['xx'])){
        if($_GET['tj']=="SID"){
            $sql = 'SELECT * FROM `iot_signup` WHERE `SID` LIKE "%'.$_GET['xx'].'%"';
            $mysql->querySQL($sql);
        }else if($_GET['tj']=="Name"){
            $sql = 'SELECT * FROM `iot_signup` WHERE `SID` = (SELECT `SID` FROM `iot_user` WHERE `Name` LIKE "%'.$_GET['xx'].'%")';
            $mysql->querySQL($sql);
        }
    }else{
        $mysql->select($table = 'iot_signup');
    }
    $i=1;
    echo "<thead><tr><th>#</th><th>学号</th><th>姓名</th><th>签到时间</th></tr></thead><tbody>";
    foreach($mysql->fetchAll() as $row){
        echo "<tr>";
        echo "<th>".$i."</th>"; 
        echo "<td>".$row['SID']."</td>"; 
        $name = getUserName($row['SID']);
        echo "<td>".$name."</td>"; 
        echo "<td>".$row['SignupTime']."</td>"; 
        echo "</tr>";
        $i++;
    }
    echo "</tbody>";
    return;
}

function getNeedCheck(){
    global $mysql ;
    $sql = 'SELECT * FROM iot_user WHERE Usercheck=1';
    $mysql->querySQL($sql);
    $i=1;
    echo "<thead><tr><th>#</th><th>学号</th><th>姓名</th><th>头像</th><th colspan='2'>操作</th></tr></thead><tbody>";
    foreach($mysql->fetchAll() as $row){
        echo "<tr>";
        echo "<th>".$i."</th>"; 
        echo "<td>".$row['SID']."</td>"; 
        echo "<td>".$row['Name']."</td>"; 
        echo "<td><img src='".$row['img']."' class='img-thumbnail' width='100px' height='auto'></td>"; 
        echo "<td><a class='font' href='check.php?action=pass&id=".$row['ID']."'>补全信息</a></td>"; 
        echo "<td><a class='font' href='del.php?id=".$row['ID']."'>删除</a></td>"; 
        echo "</tr>";
        $i++;
    }
    echo "</tbody>";
    return;
}

function getUsers(){
    global $mysql ;
    $sql = 'SELECT * FROM iot_user WHERE Usercheck=0';
    $mysql->querySQL($sql);
    $i=1;
    echo "<thead><tr><th>#</th><th>学号</th><th>姓名</th><th>头像</th><th colspan='2'>操作</th></tr></thead><tbody>";
    foreach($mysql->fetchAll() as $row){
        echo "<tr>";
        echo "<th>".$i."</th>"; 
        echo "<td>".$row['SID']."</td>"; 
        echo "<td>".$row['Name']."</td>"; 
        echo "<td><img src='".$row['img']."' class='img-thumbnail' width='100px' height='auto'></td>"; 
        echo "<td><a class='font' href='check.php?action=modify&id=".$row['ID']."'>修改信息</a></td>"; 
        echo "<td><a class='font' href='del.php?action=del&id=".$row['ID']."'>删除</a></td>"; 
        echo "</tr>";
        $i++;
    }
    echo "</tbody>";
    return;
}

function getTop3Users(){
    global $mysql ;
    $sql = "SELECT `SID`,COUNT(*) AS 'TIMES' FROM `iot_signup` GROUP BY `SID` ORDER BY COUNT(*) DESC LIMIT 3";
    $num = $mysql->querySQL($sql)->num_rows;
    //return $mysql->fetchAll();
    $users = $mysql->fetchAll();
    $sql = "SELECT * FROM `iot_signup`";
    $sum = $mysql->querySQL($sql)->num_rows;
    if($num>=1){
        echo '<div class="col-md-2 font">'.getUserName($users[0]['SID']).'</div>';
        echo '<div class="progress">';
        echo '<div class="progress-bar  progress-bar-striped active font" role="progressbar" style="min-width: 2em; width: '.($users[0]['TIMES']/$sum*100).'%;">'.$users[0]['TIMES'].'次</div>';                    
        echo '</div>';
    }
    if($num>=2){
        echo '<div class="col-md-2 font">'.getUserName($users[1]['SID']).'</div>';
        echo '<div class="progress">';
        echo '<div class="progress-bar progress-bar-info  progress-bar-striped active font" role="progressbar" style="min-width: 2em; width: '.($users[1]['TIMES']/$sum*100).'%;">'.$users[1]['TIMES'].'次</div>';                    
        echo '</div>';
    }
    if($num==3){
        echo '<div class="col-md-2 font">'.getUserName($users[2]['SID']).'</div>';
        echo '<div class="progress">';
        echo '<div class="progress-bar progress-bar-warning  progress-bar-striped active font" role="progressbar" style="min-width: 2em; width: '.($users[2]['TIMES']/$sum*100).'%;">'.$users[2]['TIMES'].'次</div>';                    
        echo '</div>';
    }
}

if(!empty($_GET['act'])){
    $tmp=$_GET['act'];
}

if(empty($tmp)){
	$tmp='main';
}

include_once('header.html');
include_once($tmp.'.html');
include_once('footer.html');
?>



        
        
        
        
    
        

        

