<?php
/*
========================================================
===                                                  ===
===               CATEGORIE PAGE                     ===
===                                                  ===
========================================================
*/
session_start();
$pageTitle = 'Categories';
if (isset($_SESSION['Username'])) { // CHESK IF THE SESSION IS SET
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // GET THE VALUE OF THE DO AND THEN LOAD THE PAGE
    if ($do == 'Manage') {
        $stmt = $db->prepare("SELECT * FROM orders ORDER BY OrderID DESC");

        $stmt->execute();
        $rows = $stmt->fetchAll();
        if (!empty($rows)) { ?>
            <div class="container p-5">
                <h1 class="position-relative fs-3 fw-bold mb-5 ">Commandes</h1>
                <table class="table text-center main_table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Client</th>
                            <th scope="col">Date</th>
                            <th scope="col">Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($rows as $row) {
                            $user = getOne($row['UserID'], 'users', 'UserID');
                            echo "<tr>";
                            echo "<th scope='row'>" . $row['OrderID'] . "</th>";
                            echo "<td>" . $user['Fullname'] . "</td>";
                            echo "<td>" . $row['OrderDate'] . "</td>";
                            echo "<td>";
                            echo "<a href='orders.php?do=Edit&orderid=" . $row['OrderID'] . "' class='btn btn-success me-1 pt-2 pb-1 ps-2 pe-2''><i class='fa-solid fa-pen-to-square  fs-5'></i></a>";
                            echo "<a href='orders.php?do=Delete&orderid=" . $row['OrderID'] . "' class='btn btn-danger confirmMembrDelete me-1 pt-2 pb-1 ps-2 pe-2'><i class='fa-solid fa-xmark fs-5'></i></a>";
                            // if ($row['Regstatus'] == 0) {
                            //     echo "<a href='members.php?do=Activate&userid=" . $row['OrderID'] . "' class='btn btn-warning me-1 pt-2 pb-1 ps-2 pe-2'><i class='fa-solid fa-check fs-5'></i></a>";
                            // }
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="container content p-5">
                <h1 class="position-relative fs-3 fw-bold">Commandes</h1>
                <div class="alert no_catg mt-5 bg-light p-4 position-relative"
                    role="alert">PAS De <strong>Commandes</strong></div>
            </div>
        <?php }
    } elseif ($do == "Add") {
    } elseif ($do == "Insert") {
    } elseif ($do == "Edit") {


        $orderid = isset($_GET['orderid']) && is_numeric($_GET['orderid']) ? intval($_GET['orderid']) : 0;

        //SELECT THE ORDER
        $order = getOne($orderid, 'orders', 'OrderID');

        //SELECT THE USER
        $user = getOne($order['UserID'], 'users', 'UserID');

        //SELECT THE ORDER DETAILS
        $orderDetails = getOrderDetails($orderid);

        ?>

        <div class="container p-5">
            <h1 class="position-relative fs-3 fw-bold mb-5 ">Modifier la Commande</h1>
            <div class="row">
                <div class="edit-user-info p-4 col-lg-8 col-md-8 col-sm-8">
                    <h5 class="text-center mb-4 fw-900">Articles</h5>
                    <ul>
                <?php foreach ($orderDetails as $orderDetail) {
                    $item = getOne($orderDetail['ItemID'], 'items', 'ItemID');
                    ?>
                    <li class='mb-2 d-flex align-items-center border p-3'>
                        <div class='item_image me-4'>
                            <img src="<?php echo $item['Image'] . "main.png" ?>"
                                alt="image">
                        </div>
                        <div class='item_desc flex-fill'>
                            <h3 class="fs-6 t-b fw-900">
                                <?php echo $item['Name'] ?>
                            </h3>
                            <span class="price d-block mb-3 fw-900">
                                <?php echo $item['Price'] ?><span> دج</span>
                            </span>
                        </div>
                        <a href="modals\orders\clientOrderEdit.php?orderid=<?php echo $orderid ?>&itemid=<?php echo $item['ItemID'] ?>"
                            class="t-b fs-4"><i class="fa-regular fa-circle-xmark"></i></a>
                    </li>
                <?php } ?>
                <li class="border-bottom pb-4 mt-4 d-flex align-items-center justify-content-between">
                    <span class="fw-900">Total</span>
                    <span class="fw-900 t-b">
                        <?php echo $order['OrderPrice'] . " دج" ?>
                    </span>
                </li>
            </ul>
        </div>
        <div class="user-card p-4 col-lg-4 col-md-4 col-sm-4">
            <h5 class="text-center mb-4 fw-900">Client</h5>
            <div class="border-b p-4">
                <ul>
                    <li class="d-flex align-items-center mb-3">
                        <i class="fa-solid fa-user me-3"></i>
                        <?php echo $user['Fullname'] ?>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="fa-solid fa-envelope me-3"></i>
                        <?php echo $user['email'] ?>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="fa-solid fa-phone me-3"></i>
                        <?php echo $order['OrderTel'] ?>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="fa-solid fa-map-location-dot me-3"></i>
                        <?php echo $order['OrderAddress'] . ", " . $order['OrderCommune'] . ", " . $order['OrderWilaya'] ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
    } elseif ($do == "Update") {
    } elseif ($do == "Delete") {
        echo '<div class="container mt-5">';
        $orderid = isset($_GET['orderid']) && is_numeric($_GET['orderid']) ? intval($_GET['orderid']) : 0;

        //CHESK IF THER IS A USER WITH THIS ID
        $chesk = chackItem('OrderID', 'orders', $orderid);

        if ($chesk > 0) {
            $stmt = $db->prepare("DELETE FROM orders WHERE OrderID = ?");
            $stmt->execute([$orderid]);
            $Msg = '<div class="alert alert-danger text-center" role="alert">commande SUPPRIMER !!!</div>';
            redirectHome($Msg, 3, 'back');

        } else {
            $Msg = '<div class="alert alert-primary text-center" role="alert">ERREUR !!!</div>';
            redirectHome($Msg, 3, 'back');
        }
        echo '</div>';
    }
    ;
    include $tpl . 'footer.php';
} else {
    header('Location: index.php'); //   redirect to index if ther is no do=
    exit();
}
?>