<?php
$dbhs = "localhost";//database hostname
$dbus = "";//mysql username
$dbnm = "backJack";//database name
$dbpw = "";//user password
$pdo=new PDO('mysql:host='.$dbhs.';port=3306;dbname='.$dbnm.';charset=utf8mb4',$dbus,$dbpw);
?>
