<?php

/*
========================================================
===                                                  ===
===               DASHBOARD PAGE                     ===
===                                                  ===
========================================================
*/

ob_start();

session_start();

if (isset($_SESSION['Username'])) {

    $pageTitle = 'Dashboard';

    include 'init.php';


    ?>
    <!-- START DASHBOARD -->
    <div class="container content p-5">
        <div class="main_stats mb-3">
            <h1 class="position-relative fs-3 fw-bold">Dashboard</h1>
            <div class="row mt-5">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat p-2 text-center fs-5 rounded-3">
                        Clients
                        <span class="d-block fs-1"><a href="members.php">
                                <?php echo countItems('UserID', 'users', 'WHERE', 'GroupID != 1'); ?>
                            </a></span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat p-2 text-center fs-5 rounded-3">
                        non valider
                        <span class="d-block fs-1"><a href="members.php?do=Manage&page=Pending">
                                <?php echo countItems('UserID', 'users', 'WHERE', 'Regstatus = 0'); ?>
                            </a></span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat p-2 text-center fs-5 rounded-3">
                        Articles
                        <span class="d-block fs-1"><a href="items.php">
                                <?php echo countItems('ItemID', 'items'); ?>
                            </a></span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat p-2 text-center fs-5 rounded-3">
                        Commandes
                        <span class="d-block fs-1">
                            <a href="orders.php">
                                <?php echo countItems('OrderID', 'orders'); ?>
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="latest">
            <div class="row">
                <!-- Employer  -->
                <div class="col-lg-6 mb-3">
                    <div class="plan">
                        <div class="top rounded-3">
                            <h2 class="text-center p-4">Employer Enregistrer</h2>
                        </div>
                        <ul class="latest_emp">
                            <?php
                            $rows = lastItems('UserID, Fullname, Regstatus', 'users', 'WHERE', 'GroupID = 0', 'UserID', 5);
                            if (!empty($rows)) {
                                foreach ($rows as $row) {
                                    echo '<li class="">';
                                    echo "<div class='d-flex align-items-center p-3 border-bottom'><span class='flex-fill'>" . $row['Fullname'] . "</span><span class='btn btn-success'><a href='members.php?do=Edit&userid=" . $row['UserID'] . "'><i class='fa-solid fa-pen-to-square light fs-5'></i></a></span>";
                                    if ($row['Regstatus'] == 0) {
                                        echo "<span class='btn btn-warning ms-1'><a href='members.php?do=Activate&userid=" . $row['UserID'] . "'><i class='fa-solid fa-check Dark fs-5'></i></a></span>";
                                    }
                                    echo "</div>";
                                    echo '</li>';
                                }
                            } else {
                                echo '<li class="p-4">La list d\'employer est <strong>vide</strong></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <!-- Commande -->
                <div class="col-lg-6 mb-3">
                    <div class="plan">
                        <div class="top rounded-3">
                            <h2 class="text-center p-4">Liste des Commande</h2>
                        </div>
                        <ul>
                            <?php
                            $rows = lastItems('OrderID, OrderDate, UserID', 'orders', 'WHERE', 'OrderID > 0', 'OrderID', 5);
                            if (!empty($rows)) {
                                foreach ($rows as $row) {
                                    $userRow = getOne($row['UserID'], 'users', 'UserID');
                                    echo '<li class="">';
                                    echo "<div class='d-flex align-items-center p-3 border-bottom'><span class='flex-fill'>" . $userRow['Fullname'] . "<span class='ms-5'>" . $row['OrderDate'] . "</span></span><span class='btn btn-success'><a href='orders.php?do=Edit&orderid=" . $row['OrderID'] . "'><i class='fa-solid fa-pen-to-square light fs-5'></i></a></span>";
                                    // if ($row['Regstatus'] == 0) {
                                    //     echo "<span class='btn btn-warning ms-1'><a href='members.php?do=Activate&userid=" . $row['OrderID'] . "'><i class='fa-solid fa-check Dark fs-5'></i></a></span>";
                                    // }
                                    echo "</div>";
                                    echo '</li>';
                                }
                            } else {
                                echo '<li class="p-4">La list d\'employer est <strong>vide</strong></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <!-- Articles -->
                <div class="col-">
                    <div class="plan">
                        <div class="top rounded-3">
                            <h2 class="text-center p-4">Liste des Articles</h2>
                        </div>
                        <ul>
                            <?php
                            $stmt = $db->prepare("SELECT * FROM items ORDER BY ItemID DESC LIMIT 5");
                            $stmt->execute();
                            $rows = $stmt->fetchAll();
                            if (!empty($rows)) {
                                foreach ($rows as $row) {
                                    echo '<li class="">';
                                    echo "<div class='d-flex align-items-center p-3 border-bottom'><span class='flex-fill'>" . $row['Name'] . "</span><span class='btn btn-success'><a href='items.php?do=Edit&itemid=" . $row['ItemID'] . "'><i class='fa-solid fa-pen-to-square light fs-5'></i></a></span>";
                                    if ($row['Approuve'] == 0) {
                                        echo "<span class='btn btn-warning ms-1'><a href='items.php?do=Approuve&itemid=" . $row['ItemID'] . "'><i class='fa-solid fa-check Dark fs-5'></i></a></span>";
                                    }
                                    echo "</div>";
                                    echo '</li>';
                                }
                            } else {
                                echo '<li class="p-4">La liste des articles est <strong>vide</strong></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- START DASHBOARD -->
    <?php

    include $tpl . 'footer.php';

} else {
    header('Location: index.php');
    exit();
}

ob_end_flush();
?>