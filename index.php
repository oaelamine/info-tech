<?php
ob_start();
session_start();
$pageTitle = 'INFO-TECH';

// if (isset($_SESSION['user'])) {
//     header('Location: index.php'); ///is user exist redirect to index.php
// }

include "init.php";

//CHEST IF USER COMING FROM HTTP REQUEST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user = $_POST['user'];
    $userpass = $_POST['userpass'];

    //HASHE THE PASSWORD
    $userhasheedpass = sha1($userpass);

    //SERCH FOR ADMINS IN THE DB GroupID = 1
    $stmt = $db->prepare("SELECT 
                                UserID, Username, Password 
                        FROM 
                            users 
                        WHERE 
                            Username = ? 
                        AND 
                            Password = ? 
                        ");
    $stmt->execute([$user, $userhasheedpass]);
    $row = $stmt->fetch();

    //THE COUNT OF THE ROWS FOUND IN THE DATABASE
    $count = $stmt->rowCount();

    if ($count > 0) {

        //CREATE THE SESSION
        $_SESSION['user'] = $user;
        $_SESSION['userid'] = $row['UserID'];
        header('Location: index.php');
    }
}
//SELECTION LAPTOPS FROM THE DB
// $stmt2 = $db->prepare("SELECT * FROM items ORDER BY ItemID DESC LIMIT 4");
$lapCat = 'laptop';
$lapstmt = $db->prepare("  SELECT items.*, cartegories.Name as catName from items
                        INNER JOIN cartegories ON cartegories.ID =items.CatID
                        WHERE cartegories.Name = ?
                        ORDER BY ItemID DESC LIMIT 4");
$lapstmt->execute([$lapCat]);
$items = $lapstmt->fetchAll();

//SELECTION SMARTPHONES FROM THE DB
// $stmt2 = $db->prepare("SELECT * FROM items ORDER BY ItemID DESC LIMIT 4");
$smartCat = 'smartphone';
$smartstmt = $db->prepare("  SELECT items.*, cartegories.Name as catName from items
                        INNER JOIN cartegories ON cartegories.ID =items.CatID
                        WHERE cartegories.Name = ?
                        ORDER BY ItemID DESC LIMIT 4");
$smartstmt->execute([$smartCat]);
$smartItems = $smartstmt->fetchAll();

//SELECTION ACSESSOIRE FROM THE DB
// $stmt2 = $db->prepare("SELECT * FROM items ORDER BY ItemID DESC LIMIT 4");
$accsCat = 'accessoires';
$accsstmt = $db->prepare("  SELECT items.*, cartegories.Name as catName from items
                        INNER JOIN cartegories ON cartegories.ID =items.CatID
                        WHERE cartegories.Name = ?
                        ORDER BY ItemID DESC LIMIT 4");
$accsstmt->execute([$accsCat]);
$accItems = $accsstmt->fetchAll();



?>

<header class="d-flex align-items-center">
    <div class="container position-relative">
        <div class="row">
            <div class="col-lg-5 col-sm-12">
                <h6 class="t-g">FOR YOU AND EVRYONE</h6>
                <h1 class="fw-bold t-w mb-4"
                    style="font-size: 350%">INFO-TECH</h1>
                <p class="t-g">Découvrez nos articles prix imbattables</p>
                <h2 class="fw-bolder t-w mb-4">Achetez maintenant !</h2>
                <div>
                    <a href="shop.php"
                        class="t-w btn btn-primary fw-bold me-1 ps-4 pe-4 pt-2 pb-2"><i
                            class="fa-solid fa-cart-shopping me-2"></i>Acheter</a>
                    <a href="#"
                        class="btn btn-light t-gd fw-bold ps-4 pe-4 pt-2 pb-2"></i>More info<i
                            class="fa-solid fa-angles-right ms-2"></i></a>
                </div>
            </div>
        </div>
        <!-- <a href="#section--1">
            <i class="more-icon fa-solid fa-angles-down t-g position-absolute"></i>
        </a> -->
    </div>
</header>
<section class="section"
    id="section--1">
    <div class="container">
        <div class="row pt-4 pb-4">
            <div class="option col-lg-4 col-md-4 col-sm-12 text-center pt-4 pb-4">
                <i class="fa-solid fa-truck-fast fs-1 t-b mb-4"></i>
                <h3 class="fw-bolder t-gd fs-5 mb-3 fw-700">Livraison gratuite</h3>
                <p class="t-g">Livraison gratuite 58 wilaya en moins de 48h</p>
            </div>
            <div class="option col-lg-4 col-md-4 col-sm-12 text-center pt-4 pb-4 border-start border-end">
                <i class="fa-solid fa-briefcase fs-1 t-b mb-4"></i>
                <h3 class="fw-bolder t-gd fs-5 mb-3 fw-700">Cartable gratuit</h3>
                <p class="t-g">Obtenez un cartable gratuit pour votre nouveau PC</p>
            </div>
            <div class="option col-lg-4 col-md-4 col-sm-12 text-center pt-4 pb-4">
                <i class="fa-solid fa-laptop fs-1 t-b mb-4"></i>
                <h3 class="fw-bolder t-gd fs-5 mb-3 fw-700">Adapté aux besoins</h3>
                <p class="t-g">Obtenez un ordinateur portable adapté à vos besoins pour plus d'efficacité</p>
            </div>
        </div>
    </div>
</section>
<section class="section"
    id="section--2">
    <div class="container p-5">
        <div class="text-center mb-5">
            <h6 class="fw-700 t-g text-uppercase">for you and evryone</h6>
            <h2 class="fw-700 t-w fs-1">Nos produits</h2>
        </div>
        <div class="row">
            <div class="prod col-md-4 col-sm-12 text-center mb-4">
                <div class="prod--img w-100"
                    style="height: 400px">
                </div>
                <div class="prod--text pt-5 pb-5">
                    <h3 class="text-uppercase t-w mb-3 fw-900">laptops</h3>
                    <a href="laptop.php"
                        class="btn btn-light rounded-pill text-uppercase ps-4 pe-4 fw-700 t-gd">acheter</a>
                </div>
            </div>
            <div class="prod col-md-4 col-sm-12 text-center mb-4">
                <div class="prod--img w-100"
                    style="height: 400px">
                </div>
                <div class="prod--text pt-5 pb-5">
                    <h3 class="text-uppercase t-w mb-3 fw-900">smartphones</h3>
                    <a href="smartphone.php"
                        class="btn btn-light rounded-pill text-uppercase ps-4 pe-4 fw-700 t-gd">acheter</a>
                </div>
            </div>
            <div class="prod col-md-4 col-sm-12 text-center mb-4">
                <div class="prod--img w-100"
                    style="height: 400px">
                </div>
                <div class="prod--text pt-5 pb-5">
                    <h3 class="text-uppercase t-w mb-3 fw-900">accessoires</h3>
                    <a href="accessoires.php"
                        class="btn btn-light rounded-pill text-uppercase ps-4 pe-4 fw-700 t-gd">acheter</a>
                </div>
            </div>
        </div>
    </div>

</section>
<section class="section"
    id="section--3">
    <div class="container pt-5 pb-5">
        <div class="text-center mb-5">
            <h2 class="section__title text-uppercase fw-900 d-flex align-items-center text-center"><b></b><span
                    class="">produies
                    à la
                    une</span><b></b></h2>
        </div>
        <div class="wrapper">
            <div class="operations__tab-container">
                <button class="btn rounded-pill operations__tab operations__tab--1 operations__tab--active"
                    data-tab="1">
                    LAPTOPS
                </button>
                <button class="btn rounded-pill operations__tab operations__tab--2"
                    data-tab="2">
                    SMARTPHONES
                </button>
                <button class="btn rounded-pill operations__tab operations__tab--3"
                    data-tab="3">
                    ACCSESSOIRE
                </button>
            </div>
            <!-- LAPTOPS -->
            <div
                class="row align-items-center mt-3 operations__tab__content operations__content--1 operations__content--active">
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
            <!-- SMARTPHONES -->
            <div class="row align-items-center mt-3 operations__tab__content operations__content--2 ">
                <?php if (empty($smartItems)) { ?>
                    <div style="height: 338px;"
                        class="mt-3">
                        <h4 class="col- text-center mt-3">PAS DE SMARTPHONES</h4>
                    </div>
                <?php } ?>
                <?php foreach ($smartItems as $smartItem) { ?>
                    <div class="prod col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-3">
                        <div class="card border">
                            <div class="card--img w-100">
                                <img class=""
                                    src="<?php echo "admin/" . $smartItem['Image'] . "main.png" ?>"
                                    alt="">
                            </div>
                            <div class="card-body">
                                <a href="#"
                                    class="card--name mb-0">SMARTPHONES <?php echo $smartItem['Name'] ?></a>
                                <span class="price mb-2 d-block">
                                    <bdi class="fw-900">
                                        <?php echo $smartItem['Price'] ?>
                                    </bdi>
                                    <span class="fw-900"> د.ج</span>
                                </span>
                                <div class="mt-3 d-flex align-items-center">
                                    <span class="fw-900 d-block flex-fill">Lire plus</span>
                                    <a href="articleInfo.php?id=<?php echo $smartItem['ItemID'] ?>">
                                        <i class="fa-solid fa-arrow-right t-b   "></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- SMARTPHONES -->
            <!-- ACCESSOIRE -->
            <div class="row align-items-center mt-3 operations__tab__content operations__content--3 ">
                <?php if (empty($accItems)) { ?>
                    <div style="height: 338px;"
                        class="mt-3">
                        <h4 class="col- text-center mt-3">PAS D'ACCESSOIRE</h4>
                    </div>
                <?php } ?>
                <?php foreach ($accItems as $accItem) { ?>
                    <div class="prod col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-3">
                        <div class="card border">
                            <div class="card--img w-100">
                                <img class=""
                                    src="<?php echo "admin/" . $accItem['Image'] . "main.png" ?>"
                                    alt="">
                            </div>
                            <div class="card-body">
                                <a href="#"
                                    class="card--name mb-0">ACCESSOIRE <?php echo $accItem['Name'] ?></a>
                                <span class="price mb-2 d-block">
                                    <bdi class="fw-900">
                                        <?php echo $accItem['Price'] ?>
                                    </bdi>
                                    <span class="fw-900"> د.ج</span>
                                </span>
                                <div class="mt-3 d-flex align-items-center">
                                    <span class="fw-900 d-block flex-fill">Lire plus</span>
                                    <a href="articleInfo.php?id=<?php echo $accItem['ItemID'] ?>">
                                        <i class="fa-solid fa-arrow-right t-b   "></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- SMARTPHONES -->
        </div>
    </div>
</section>
<section class="section"
    id="section--4">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section__title text-uppercase fw-900 d-flex align-items-center text-center"><b></b><span
                    class="">Lancement</span><b></b></h2>
        </div>
        <div class="ct-wrapper d-flex align-items-center">
            <div class="bg-blue rounded text-center p-3">
                <span class="days d-block fw-900 t-w fs-1">30</span>
                <span class="d-block fw-900 t-w fs-5">Days</span>
            </div>
            <div class="bg-blue rounded text-center p-3">
                <span class="hours d-block fw-900 t-w fs-1">18</span>
                <span class="d-block fw-900 t-w fs-5">Hours</span>
            </div>
            <div class="bg-blue rounded text-center p-3">
                <span class="minutes d-block fw-900 t-w fs-1">49</span>
                <span class="d-block fw-900 t-w fs-5">Minutes</span>
            </div>
            <div class="bg-blue rounded text-center p-3">
                <span class="seconds d-block fw-900 t-w fs-1">33</span>
                <span class="d-block fw-900 t-w fs-5">Seconds</span>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="login-modal hidden">
        <button class="btn--close-modal">&times;</button>
        <h2 class="modal__header fw-bold text-center">
            CONNEXTION
        </h2>
        <form class="modal__form"
            action="<?php $_SERVER['PHP_SELF'] ?>"
            method="POST">
            <div class="mb-4">
                <label class="form-label fw-bold"
                    for="user">Identifiant*</label>
                <input class="form-control"
                    id="user"
                    type="text"
                    name="user"
                    required="required" />
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold"
                    for="userpass">Mot de passe *</label>
                <input class="form-control"
                    id="userpass"
                    type="password"
                    name="userpass"
                    required="required" />
            </div>
            <button type="submit"
                class="modal__btn text-uppercase">Se Connecter</button>
        </form>
        <div class="mt-4">
            <p>vous n'avez pas de compte ? <a class="text-uppercase"
                    href="signin.php">S'ENREGISTRER</a></p>
        </div>
    </div>
</div>
<div class="overlay hidden"></div>
<?php
include $tpl . "footer.php";
ob_end_flush();
?>