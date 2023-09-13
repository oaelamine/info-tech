<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"
        content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>
        <?php gatTitel(); ?>
    </title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet"
        href="<?php echo $css ?>all.min.css">
    <link rel="stylesheet"
        href="<?php echo $css ?>bootstrap.min.css">
    <link rel="stylesheet"
        href="<?php echo $css ?>style.css">
    <script src="<?php echo $js; ?>front.js"
        defer></script>
</head>

<?php
// ###################################################
//CHEST IF USER COMING FROM HTTP REQUEST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user']) && isset($_POST['userpass'])) {

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
        // header('Location: index.php');
    }
}
// ###################################################

?>

<body>
    <?php
    $catgs = getCats();
    ?>
    <!-- ###############################################################################################" -->
    <!-- TOP NAVBAR START -->
    <div class="sticky-top bg-white">
        <nav class="logo-navbar navbar navbar-expand-lg p-0 d-flex mb-md-3 mb-sm-3">
            <div class="container">
                <div class="me-4">
                    <img class="logo"
                        src="<?php echo $imgs ?>logo.png"
                        alt="Logo">
                    <span class="fw-bold">INFO-TACH</span>
                </div>
                <div class="flex-grow-1 d-flex me-4">
                    <input class="flex-grow-1 ps-3 pe-3 pt-1 pb-1"
                        type="search"
                        name="serch"
                        id="serch"
                        placeholder="Recherche....">
                    <button class="btn-serch border-0 ps-2 pe-2"
                        type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                <div class="d-flex border-end login-signup">
                    <?php if (!isset($_SESSION['user'])) { ?>
                        <span class="text-dark btn--show-modal">CONNEXION/S'ENREGISTRER</span>
                        <!-- <a class="text-dark btn--show-modal"
                        href="#">CONNEXION/S'ENREGISTRER</a> -->
                    <?php } else { ?>
                        <span class="user-menu d-block login-btn p-3">
                            <?php
                            echo $_SESSION['user']; ?>
                            <i class="ms-2 fa-solid fa-user"></i>
                            <ul class="user-dp-menu p-2">
                                <li><a class="border-bottom"
                                        href="orders.php">Commands</a></li>
                                <li><a class="border-bottom"
                                        href="#">Favoris</a></li>
                                <li><a class="border-bottom"
                                        href="infoacount.php">Détaille du compte</a></li>
                                <li><a href="logout.php">Déconnextion</a></li>
                            </ul>
                        </span>
                    <?php } ?>
                </div>
                <div class="shop-cart text-dark p-3 d-block">
                    <span class="cart-price">PANIER / 0,00DA</span>
                    <span class="cart-icon position-relative">
                        <?php
                        if (isset($_SESSION['cart'])) {
                            echo count($_SESSION['cart']);
                        } else {
                            echo '0';
                        }
                        ?>
                        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
                            <form class="cart cart-form position-absolute hide p-2"
                                action="orders.php"
                                method="POST">
                                <ul class="cart_items p-2 mb-0">
                                    <?php foreach ($_SESSION['cart'] as $item) {
                                        $stmt = $db->prepare("SELECT Name, Price, Image FROM items WHERE ItemID = ?");
                                        $stmt->execute([$item]);
                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <li class="cart_item_li border-bottom">
                                            <input type="text"
                                                name="cartItemIdXXX[]"
                                                value="<?php echo $item ?>"
                                                hidden>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="cart_image me-2">
                                                    <img src="<?php echo "admin/" . $row['Image'] . "main.png" ?>"
                                                        alt="image">
                                                </div>
                                                <div class="cart_info me-3">
                                                    <p class="mb-0 t-b fw-900">
                                                        <?php echo $row['Name'] ?>
                                                    </p>
                                                    <span class="cart_price d-block mb-3">
                                                        <?php echo $row['Price'] ?><span>دج</span>
                                                    </span>
                                                </div>
                                                <div>
                                                    <a
                                                        href="modals/orders/orderItemDelet.php?page=laptop&itemid=<?php echo $item ?>"><i
                                                            class="fa-regular fa-circle-xmark fs-3 t-b"></i></a>
                                                    <!-- <span class="cart_delet"><i class="fa-regular fa-circle-xmark fs-3"></i></span> -->
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                    <?php if (isset($_SESSION['cart'])) { ?>
                                        <button class="text-uppercase modal__btn ps-2 pe-2 pt-1 pb-1 fs-6 me-2 w-100 mt-2"
                                            type="submit">Commander</button>
                                    <?php } ?>
                                </ul>
                            </form>
                        <?php } else { ?>
                            <p class="cart cart_empty position-absolute p-2 text-center hide">Votre Panier est vide</p>
                        <?php } ?>
                    </span>
                </div>
            </div>
        </nav>
        <!-- TOP NAVBAR END -->
        <!-- MAIN NAVBAR  navbar-dark   bg-primary   text-light-->
        <nav class="shop-navbar navbar navbar-expand-md  navbar-dark p-0">
            <div class="container">
                <a class="navbar-brand"
                    href="index.php">
                    <?php echo lang('ADMIN_HOME') ?>
                </a>
                <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse w-100"
                    id="navbarNavDropdown">
                    <ul class="navbar-nav flex-grow-1">
                        <li class="nav-item">
                            <a class="nav-link"
                                href="shop.php">
                                <?php echo lang('SHOP') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="#">
                                <?php echo lang('A PROPOS') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="#">
                                <?php echo lang('CONTACT') ?>
                            </a>
                        </li>
                        <li class="compt-lick nav-item position-relative">
                            <a class="nav-link"
                                href="#">
                                <?php echo lang('MON COMPTE') ?>
                                <i class="fa-solid fa-chevron-down ms-1"></i>
                            </a>
                            <ul class="position-absolute compt-menu hide p-2">
                                <li><a class="d-block w-100 border-bottom"
                                        href="#">Panier</a></li>
                                <li><a class="d-block w-100 border-bottom"
                                        href="orders.php">Commands</a></li>
                                <li><a class="d-block w-100"
                                        href="#">Favoris</a></li>
                            </ul>
                        </li>
                        <?php foreach ($catgs as $catg) { ?>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="<?php echo $catg['Name'] . ".php" ?>">
                                    <?php echo $catg['Name'] . 's' ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- ###############################################################################################" -->
    <!-- LOGIN MODAL -->
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