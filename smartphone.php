<?php
ob_start();
session_start();
$pageTitle = 'SMARTPHONES';
include 'init.php';

if (isset($_SESSION['user'])) {

    $stmt = $db->prepare("SELECT * from users WHERE UserID = ?");
    $stmt->execute([$_SESSION['userid']]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // header('Location: index.php');
}

//SELECTING ITEMS
$categorie = 'smartphone';

$stmt = $db->prepare("  SELECT items.*, cartegories.Name as Name from items
                        INNER JOIN cartegories ON cartegories.ID =items.CatID
                        WHERE cartegories.Name = ?");
$stmt->execute([$categorie]);
$rows = $stmt->fetchAll();

//INSERING IN CART
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['artid']) && isset($_SESSION['user'])) {

    $_SESSION['cart'][] = $_POST['artid'];

    header('Location: smartphone.php');

} elseif (isset($_POST['artid']) && !isset($_SESSION['user'])) {

    header('Location: login.php');
}
;
?>

<div class="container mt-3">
    <h1 class="text-center text-uppercase">smartphone</h1>
    <div class="articles">
        <div class="row">
            <?php if (empty($rows)) { ?>
                <p class="text-center mt-5">Aucun produit ne correspond à votre sélection.</p>
            <?php } ?>
            <?php foreach ($rows as $row) { ?>
                <form class="article_box text-center col-lg-4 col-md-4 col-sm-6"
                    action="<?php $_SERVER['PHP_SELF'] ?>"
                    method="POST">
                    <input type="text"
                        name="artid"
                        value="<?php echo $row['ItemID'] ?>"
                        hidden>
                    <!-- article image -->
                    <div class="article_image">
                        <a href="articleInfo.php?id=<?php echo $row['ItemID'] ?>">
                            <img src="<?php echo "admin/" . $row['Image'] . "main.png" ?>"
                                alt="image">
                        </a>
                    </div>
                    <div class="article_text">
                        <h3 class="fs-6">
                            <?php echo $row['Name'] ?>
                        </h3>
                        <span class="price d-block mb-3">
                            <?php echo $row['Price'] ?><span>دج</span>
                        </span>
                        <div class="d-flex align-items-center justify-content-center">
                            <button class="text-uppercase modal__btn ps-2 pe-2 pt-1 pb-1 fs-6 me-2"
                                type="submit">ajouter au panier</button>
                            <!-- <a href="#">
                                <i class="fa-regular fa-heart fs-4 t-b"></i>
                            </a> -->
                        </div>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>


<?php

include $tpl . 'footer.php';

ob_end_flush()
    ?>