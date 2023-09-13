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


//GET THE CATEGORY NAME

// $category = isset($_GET['category']) ? $_GET['category'] : 'laptop';

$category = 'laptop';

$category_option = ['laptop', 'smartphone', 'accessoires'];

if (isset($_GET['category']) && in_array($_GET['category'], $category_option)) {
    $category = $_GET['category'];
}

//SELECTION LAPTOPS FROM THE DB
// $stmt2 = $db->prepare("SELECT * FROM items ORDER BY ItemID DESC LIMIT 4");
// $lapCat = 'laptop';
$lapstmt = $db->prepare("  SELECT items.*, cartegories.Name as catName from items
                        INNER JOIN cartegories ON cartegories.ID =items.CatID
                        WHERE cartegories.Name = ?
                        ORDER BY ItemID DESC");
$lapstmt->execute([$category]);
$items = $lapstmt->fetchAll();


?>
<div class="container mt-4 mb-5">
    <section class="section"
        id="section--3">
        <div class="container pt-5 pb-5">
            <div class="text-center mb-5">
                <h2 class="section__title text-uppercase fw-900 d-flex align-items-center text-center"><b></b><span
                        class="">SHOP</span><b></b></h2>
            </div>
            <div class="wrapper d-flex">
                <div class="shop__links d-flex flex-column me-5">
                    <h6 class="fw-900 t-g mb-5">PRODUCT CATEGORIES</h6>
                    <ul class="shop__links d-flex flex-column">
                        <li>
                            <a href="?category=laptops"
                                class="shop__link border-bottom shop__link-active">
                                LAPTOPS
                            </a>
                        </li>
                        <li>
                            <a href="?category=smartphone"
                                class="shop__link border-bottom">
                                SMARTPHONES
                            </a>
                        </li>
                        <li>
                            <a href="?category=accessoires"
                                class="shop__link border-bottom">
                                ACCSESSOIRE
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- LAPTOPS -->
                <div
                    class="row align-items-center operations__tab__content operations__content--1 operations__content--active">
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
                <!-- LAPTOPS -->
            </div>
        </div>
    </section>
</div>
<?php
include $tpl . 'footer.php';
ob_end_flush()
    ?>