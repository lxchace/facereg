<?php
require_once 'core.php';

function getInf($ID){
    global $mysql ;
    global $src;
    $sql = 'SELECT * FROM iot_user WHERE ID='.$ID;
    $mysql->querySQL($sql);
    //print_r($mysql->fetchAll());
    $src = $mysql->fetchAll();
    return $src[0];
}

$inf = getInf($_GET["id"]);
//var_dump($inf);

include_once('header.html');
include_once('check.html'); 
include_once('footer.html');
?>