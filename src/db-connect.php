<?php
const SERVER = 'mysql220.phy.lolipop.lan';
const DBNAME = 'LAA1517337-final';
const USER = 'LAA1517337';
const PASS = 'Ryuto1130';
$connect = 'mysql:host='.SERVER.';dbname='.DBNAME.';charset=utf8';
$pdo = new PDO($connect, USER, PASS);
?>
