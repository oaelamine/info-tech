<?php 

$dns = 'mysql:host=localhost;dbname=ecodb';
$user = 'root';
$password = '';
$option = [
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
];

try {
    $db = new PDO($dns, $user, $password, $option);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch ( PDOException $e) {
    echo 'Fail to connect' . $e->getMessage();
}