<?php
session_start();

$artid = $_GET['artid'];

//INSERING THE ORDER
if (isset($artid) && isset($_SESSION['user'])) {

    $_SESSION['cart'][] = $artid;

    header('Location: ../../laptop.php');

} elseif (isset($artid) && !isset($_SESSION['user'])) {

    header('Location: ../../login.php');
}
;
?>