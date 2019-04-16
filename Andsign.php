<?php
require_once('core.php');

function getSignRecord(){
    global $mysql ;
    $mysql->select($table = 'iot_signup');
    $i=1;
    $signrec = array();
    foreach($mysql->fetchAll() as $row){
        $rec = array();
        $rec['ID'] = $i;
        $rec['SID'] = $row['SID'];
        $name = getUserName($row['SID']);
        $rec['name'] = $name;
        $rec['SignupTime'] = $row['SignupTime'];
        $signrec[] = $rec;
        $i++;
    }
    return $signrec;
}

echo json_encode(getSignRecord());
