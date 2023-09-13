<?php
ob_start();
session_start();
// $pageTitle = 'Detaille du compte';
include 'init.php';

if (isset($_SESSION['user'])) {

    $stmt = $db->prepare("SELECT * from users WHERE UserID = ?");
    $stmt->execute([$_SESSION['userid']]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // header('Location: index.php');
}

$id = $_GET['id'];


$stmt = $db->prepare("SELECT * FROM items WHERE ItemID = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$pageTitle = $row['Name'];

//SELECT RELATED ARTICLES
$lapCat = 'laptop';
$lapstmt = $db->prepare("  SELECT items.*, cartegories.Name as catName from items
                        INNER JOIN cartegories ON cartegories.ID =items.CatID
                        WHERE cartegories.Name = ?
                        ORDER BY ItemID DESC LIMIT 4");
$lapstmt->execute([$lapCat]);
$items = $lapstmt->fetchAll();

?>

<div class="container mt-5 mb-5">
    <div class="art_title">
        <h2 class="text-center mb-5 fw-900 t-g">
            <?php echo $row['Name'] ?>
        </h2>
    </div>
    <div class="row border-bottom">
        <div class="art_sec_imgs col-lg-2">
            <img src="<?php echo "admin/" . $row['Image'] . "main.png" ?>"
                alt="">
            <img src="<?php echo "admin/" . $row['Image'] . "1.jpg" ?>"
                alt="">
            <img src="<?php echo "admin/" . $row['Image'] . "2.jpg" ?>"
                alt="">
            <img src="<?php echo "admin/" . $row['Image'] . "3.jpg" ?>"
                alt="">
        </div>
        <div class="art_main_img col-lg-6">
            <img src="<?php echo "admin/" . $row['Image'] . "main.png" ?>"
                alt="">
        </div>
        <div class="art_desc col-lg-4">
            <span class="art_price d-block fw-900 fs-3 text-center mb-3">
                <?php echo $row['Price'] ?><span> دج</span>
            </span>
            <p>
                <?php echo $row['Descreption'] ?>
            </p>
            <div class="">
                <a href="modals/orders/addToCart.php?artid=<?php echo $id ?>"
                    class="modal__btn">Ajouter au panier</a>
            </div>
        </div>
    </div>
    <div class="related mt-3">
        <h4 class="fw-900 t-g">PRODUITS SIMILAIRES</h4>
        <div class="row align-items-center">
            <?php if (empty($items)) { ?>
                <div style="height: 338px;"
                    class="mt-3">
                    <h4 class="col- text-center mt-3">PAS DE LAPTOP</h4>
                </div>
            <?php } ?>
            <?php foreach ($items as $item) { ?>
                <div class="prod col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-3">
                    <div class="card border">
                        <div class="card--img w-100">
                            <img class=""
                                src="<?php echo "admin/" . $item['Image'] . "main.png" ?>"
                                alt="">
                        </div>
                        <div class="card-body">
                            <a href="#"
                                class="card--name mb-0"><?php echo $item['Name'] ?></a>
                            <span class="price mb-2 d-block">
                                <bdi class="fw-900">
                                    <?php echo $item['Price'] ?>
                                </bdi>
                                <span class="fw-900"> د.ج</span>
                            </span>
                            <div class="mt-3 d-flex align-items-center">
                                <span class="fw-900 d-block flex-fill">Lire plus</span>
                                <a href="articleInfo.php?id=<?php echo $item['ItemID'] ?>">
                                    <i class="fa-solid fa-arrow-right t-b   "></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>






<?php
include $tpl . 'footer.php';

ob_end_flush()
    ?>