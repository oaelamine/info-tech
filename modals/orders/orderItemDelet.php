<?php
// http://localhost/e-commerce-proto/modals/orders/orderItemDelet.php
ob_start();
session_start();

$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
$page = $_GET['page'] . ".php";

// Remove element from the array
// Find the index of the element to remove
$elementToRemove = $itemid;
$index = array_search($elementToRemove, $_SESSION['cart']);

// If the element is found, remove it
if ($index !== false) {
    unset($_SESSION['cart'][$index]);
}

header('Location: ../../' . $page);

ob_end_flush();
exit();
?>