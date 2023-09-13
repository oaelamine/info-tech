<?php
ob_start();
session_start();
$pageTitle = 'LAPTOPS';
include 'init.php';

if (isset($_SESSION['user'])) {

    $stmt = $db->prepare("SELECT * from users WHERE UserID = ?");
    $stmt->execute([$_SESSION['userid']]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // header('Location: index.php');
}


// var_dump($_SESSION['cart']);

// ###################################################

//ORDER INSERT FUNCTION 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cartItemId']) && !empty($_POST['cartItemId'])) {

    $userid = $_SESSION['userid'];

    $itemsid = $_POST['cartItemId'];

    $total = $_POST['total'];
    $address = $_POST['address'];
    $wilaya = $_POST['wilaya'];
    $commune = $_POST['commune'];
    $phone = $_POST['phone'];


    //INSERT THE ORDER
    $stmt = $db->prepare("   INSERT INTO orders (OrderDate, OrderPrice, OrderAddress, OrderWilaya, OrderCommune, OrderTel ,UserID) 
                                VALUES (now(), :OrderPrice, :OrderAddress, :OrderWilaya, :OrderCommune, :OrderTel, :UserID)");

    $stmt->execute([
        'OrderPrice' => $total,
        'OrderAddress' => $address,
        'OrderWilaya' => $wilaya,
        'OrderCommune' => $commune,
        'OrderTel' => $phone,
        'UserID' => $userid
    ]);

    //GET THE LAST INSERTED ORDER 
    $lastOrder = getLastItemID('OrderID', 'orders', 'OrderID', 1);

    //INSERT THE ORDER_DETAILS
    foreach ($itemsid as $id) {
        $stmt2 = $db->prepare("INSERT INTO orders_details (OrderID, ItemID ) VALUES (:OrderID , :ItemID)");
        $stmt2->execute([
            'OrderID' => $lastOrder['OrderID'],
            'ItemID' => $id
        ]);
    }

    // unset($_SESSION['cart']);
    // header('Location: order.php');

    $count = $stmt->rowCount();

    if ($count > 0) {
        unset($_SESSION['cart']);
        header('Location: index.php');
    }
}

?>
<div class="container mt-3 mb-5">
    <h1 class="text-center text-uppercase mb-5">Détails de la Commande</h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>"
        method="POST">
        <div class="row">
            <div class="client_info col-lg-7 col-md-7 col-sm-12 p-4">
                <h3 class='text-uppercase mb-4'>détails de facturation</h3>
                <!-- address -->
                <div class="address mb-4">
                    <label class="form-label t-b fw-900"
                        for="address">Adresse *</label>
                    <input class="form-control"
                        type="text"
                        name="address"
                        id="address">
                </div>
                <!-- wilaya -->
                <div class="wilaya mb-4">
                    <label class="form-label t-b fw-900"
                        for="wilaya">Wilaya *</label>
                    <select class="form-control"
                        name="wilaya"
                        id="wilaya">
                        <option value="alger">Alger</option>
                        <option value="Blida">Blida</option>
                        <option value="Boumerdass">Boumerdass</option>
                        <option value="Telemsen">Telemsen</option>
                        <option value="Djelda">Djelda</option>
                        <option value="Oran">Oran</option>
                    </select>
                </div>
                <!-- Commune -->
                <div class="commune mb-4">
                    <label class="form-label t-b fw-900"
                        for="commune">Commune *</label>
                    <input class="form-control"
                        type="text"
                        name="commune"
                        id="commune">
                </div>
                <!-- phone -->
                <div class="phone mb-4">
                    <label class="form-label t-b fw-900"
                        for="phone">Téléphone *</label>
                    <input class="form-control"
                        type="text"
                        name="phone"
                        id="phone">
                </div>
            </div>
            <div class="ordered col-lg-5 col-md-5 col-sm-12 p-4">
                <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
                    <ul class="order_items p-2 mb-0">
                        <?php foreach ($_SESSION['cart'] as $item) {
                            $stmt = $db->prepare("SELECT Name, Price, Image FROM items WHERE ItemID = ?");
                            $stmt->execute([$item]);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <li class="order_item_li border-bottom">
                                <input type="text"
                                    name="cartItemId[]"
                                    value="<?php echo $item ?>"
                                    hidden>
                                <div class="d-flex align-items-center">
                                    <div class="order_image me-2">
                                        <img src="<?php echo "admin/" . $row['Image'] . "main.png" ?>"
                                            alt="image">
                                    </div>
                                    <div class="order_info flex-fill">
                                        <p class="mb-3 t-b fw-900">
                                            <?php echo $row['Name'] ?>
                                        </p>
                                        <span class="order_price d-block mb-3 fw-900">
                                            <?php echo $row['Price'] ?><span> دج</span>
                                        </span>
                                    </div>
                                    <div>
                                        <a href="modals/orders/orderItemDelet.php?page=orders&itemid=<?php echo $item ?>"><i
                                                class="fa-regular fa-circle-xmark fs-3 t-b"></i></a>
                                        <!-- <span class="cart_delet"><i class="fa-regular fa-circle-xmark fs-3"></i></span> -->
                                    </div>
                                </div>
                            </li>
                        <?php }
                        $total = 0;
                        foreach ($_SESSION['cart'] as $item) {
                            $stmt = $db->prepare("SELECT Name, Price, Image FROM items WHERE ItemID = ?");
                            $stmt->execute([$item]);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                            $total += intval($row['Price']);
                        }
                        ?>
                        <div
                            class="total mt-4 border-bottom border-3 p-1 d-flex align-items-center justify-content-between">
                            <label class="fw-900 t-g"
                                for="total">Total</label>
                            <div>
                                <input class="orderTotal border-0 fw-900 t-b"
                                    type="text"
                                    name="total"
                                    id="total"
                                    value="<?php echo $total ?>,00"
                                    readonly>
                                <span class="t-b fw-900"> دج</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="fw-900 t-b mb-1">Paiement à la livraison</p>
                            <p class="">Payez en espèces à la livraison.</p>
                        </div>
                        <?php if (isset($_SESSION['cart'])) { ?>
                            <button class="text-uppercase modal__btn ps-3 pe-3 pt-2 pb-2 fs-6 me-2 mt-4"
                                type="submit">Commander</button>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p class="p-2 text-center mb-0 fw-900">Votre Panier est vide</p>
                <?php } ?>
            </div>
        </div>
    </form>
</div>



<?php

include $tpl . 'footer.php';

ob_end_flush()
    ?>