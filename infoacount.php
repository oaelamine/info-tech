<?php
ob_start();
session_start();
$pageTitle = 'Detaille du compte';
include 'init.php';

if (isset($_SESSION['user'])) {

    $stmt = $db->prepare("SELECT * from users WHERE UserID = ?");
    $stmt->execute([$_SESSION['userid']]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header('Location: index.php');
}

?>
<div class="container mt-3">
    <?php if (isset($_SESSION['user'])) { ?>
        <div>
            <h1 class="position-relative fs-3 fw-bold mb-0">MON COMPTE</h1>
            <p>DÉTAILS DU COMPTE</p>
        </div>
        <div class="row mt-5 p-3">
            <div class="user-card col-lg-3 col-md-3 col-sm-3 border-end p-0">
                <div>
                    <img class="me-4 rounded-circle"
                        src="layout/imgs/infoUser.png"
                        alt="avater">
                    <?php echo $_SESSION['user'] ?>
                </div>
                <div class="mt-4">
                    <ul class="page-user-menu">
                        <li>
                            <a class="t-g ps-2 pe-2 pt-2 pb-2 d-block border-bottom"
                                href="#">Commandes</a>
                        </li>
                        <li>
                            <a class="t-g ps-2 pe-2 pt-2 pb-2 d-block border-bottom"
                                href="#">Favorie</a>
                        </li>
                        <li>
                            <a class="t-g ps-2 pe-2 pt-2 pb-2 d-block border-bottom active-link"
                                href="infoacount.php">Detaill du compte</a>
                        </li>
                        <li>
                            <a class="t-g ps-2 pe-2 pt-2 pb-2 d-block border-bottom"
                                href="logout.php">Déconnextion</a>
                        </li>
                    </ul>
                </div>
            </div>
            <form class="edit-user-info col-lg-9 col-md-9 col-sm-9 p-4"
                method="POST"
                action="<?php $_SERVER['PHP_SELF'] ?>">
                <input type="text"
                    name="userid"
                    id="userid"
                    value="<?php echo $row['UserID']; ?>"
                    hidden>
                <!-- full name -->
                <div></div>
                <div class="mb-4">
                    <label class="form-label fw-bold"
                        for="fullname">Nom et Prenom *</label>
                    <input class="form-control"
                        type="text"
                        name="fullname"
                        id="fullname"
                        value="<?php echo $row['Fullname'] ?>"
                        required="required">
                </div>
                <!-- Idontifiant -->
                <div class="mb-4">
                    <label class="form-label fw-bold"
                        for="username">Idontifiant *</label>
                    <input class="form-control"
                        type="text"
                        name="username"
                        id="username"
                        value="<?php echo $row['Username'] ?>"
                        required="required">
                </div>
                <!-- email -->
                <div class="mb-4">
                    <label class="form-label fw-bold"
                        for="username">E-mail *</label>
                    <input class="form-control"
                        type="email"
                        name="email"
                        id="email"
                        value="<?php echo $row['email'] ?>"
                        required="required">
                </div>
                <!-- password -->
                <input type="password"
                    hidden
                    name="oldpassword"
                    value="<?php echo $row['Password'] ?>">
                <div class="mb-4">
                    <label class="form-label fw-bold"
                        for="newpassword">Mot de pass *</label>
                    <input class="form-control"
                        type="password"
                        name="newpassword"
                        id="newpassword"
                        autocomplete="new-password"
                        placeholder="Laisser ce champ vide si vous ne voulez pas changer votre mot de pass ">
                </div>
                <button class="
                    modal__btn
                    mt-4"
                    type="submit">ENREGISTRER LES MODIFICATIONS</button>
            </form>
        </div>
    <?php } else { ?>

    <?php } ?>
</div>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $userid = $_POST['userid'];
    $full = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

    //FROM VALIDATION
    $formErrors = [];
    if (empty($full)) {
        $formErrors[] = 'Full Name filed cant bee empty';
    }
    ;
    if (strlen($full) < 4) {
        $formErrors[] = 'Full Name cant bee less then 4 charecters';
    }
    ;
    if (strlen($full) > 30) {
        $formErrors[] = 'Full Name cant bee more then 30 charecters';
    }
    ;
    if (strlen($username) < 4) {
        $formErrors[] = 'User Name cant bee less then 4 charecters';
    }
    ;
    if (strlen($username) > 20) {
        $formErrors[] = 'User Name cant bee more then 20 charecters';
    }
    ;
    if (empty($username)) {
        $formErrors[] = 'User Name filed cant bee empty';
    }
    ;
    if (empty($email)) {
        $formErrors[] = 'email filed cant bee empty';
    }
    ;
    if (empty($formErrors)) {

        $check = chackItem('UserID', 'users', $userid);
        if ($check > 0) {
            $stmt = $db->prepare("  UPDATE 
                                        users
                                    SET
                                        Username = ?,
                                        Password = ?,
                                        email = ?,
                                        Fullname = ?
                                    WHERE
                                        UserID = ?");
            $stmt->execute([$username, $pass, $email, $full, $userid]);

            $_SESSION['user'] = $username;
            header('Location: infoacount.php');
            exit();
        }
    }
}

include $tpl . 'footer.php';

ob_end_flush()
    ?>