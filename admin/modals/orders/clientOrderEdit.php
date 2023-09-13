<?php
include '../../connect.php';

// DELETE FROM `orders_details` WHERE `orders_details`.`OrderID` = 23 AND `orders_details`.`ItemID` = 24
//\admin\modals\orders\clientOrderEdit.php
// $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

$orderid = $_GET['orderid'];
$itemid = $_GET['itemid'];

$page = "../../orders.php?do=Edit&orderid=$orderid";

//DELETE THE CHOSEN ITEM
$stmt = $db->prepare("DELETE FROM orders_details WHERE orders_details.OrderID = :OrderID AND orders_details.ItemID = :ItemID");

$stmt->execute([
    'OrderID' => $orderid,
    'ItemID' => $itemid
]);

//UPDATING THE TOTAL PRICE
//select the reamining items
$stmt1 = $db->prepare(" SELECT orders_details.*, items.Price AS Price FROM orders_details
                        INNER JOIN items ON items.ItemID = orders_details.ItemID
                        WHERE OrderID = ?
                    ");

$stmt1->execute([$orderid]);
$items = $stmt1->fetchAll();

$total = 0;
foreach ($items as $item) {
    $total += intval($item['Price']);
}
;

//UPDATING ORDER PRICE
$stmt2 = $db->prepare("UPDATE orders SET OrderPrice = ? WHERE OrderID = ?");
$stmt2->execute([$total, $orderid]);



$count = $stmt2->rowCount();

if ($count > 0) {
    header("Location: $page");
}
?>