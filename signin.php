<?php
ob_start();
$pageTitle = 'S\'ENREGISTRE';
include "init.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $full = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashpass = sha1($password);

    //FROM VALIDATION
    $formErrors = [];
    if (empty($full)) {
        $formErrors[] = 'Full Name filed cant bee empty';
    }
    ;
    if (strlen($full) < 4) {
        $formErrors[] = 'User Name cant bee less then 4 charecters';
    }
    ;
    if (strlen($full) > 30) {
        $formErrors[] = 'User Name cant bee more then 30 charecters';
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
    if (empty($password)) {
        $formErrors[] = 'password filed cant bee empty';
    }
    ;
    if (empty($email)) {
        $formErrors[] = 'email filed cant bee empty';
    }
    ;

    //CHESK IF THER IS NO ERRORS AND INSERT THE NEW MEMBER
    if (empty($formErrors)) {
        $itemCount = chackItem('Username', 'users', $username);
        if ($itemCount == 0) {
            $stmt = $db->prepare("INSERT INTO 
                                            users (Username, Password, email, Fullname, Regstatus,  Date) 
                                            VALUES (:Username, :Password, :email, :Fullname, 1, now()) ");

            $stmt->execute([
                'Username' => $username,
                'Password' => $hashpass,
                'email' => $email,
                'Fullname' => $full
            ]);

            //CHESK IF THE DB HASE BEN UPDATED
            $count = $stmt->rowCount();

            if ($count > 0) {
                header('Location: login.php');

                //     $Msg = '<div class="alert alert-success text-center" role="alert">MEMBER INSERTED !!</div>';
                //     redirectHome($Msg, 5, 'back');
                // } else {
                //     $Msg = '<div class="alert alert-danger text-center" role="alert">A PROBLEM HASS ACURE</div>';
                //     redirectHome($Msg, 5, 'back');
            }
            ;
        } else {
            echo "<div class='alert alert-danger text-center'><strong>Identifiant</strong> est déjat utiliser</div>";
            // $Msg = "<div class='alert alert-danger text-center'>This Username Alredy Existe</div>";
            // redirectHome($Msg, 5, 'back');
        }
    }

}


?>

<div class="container">
    <div class="signin col-lg-6 col-sm-12 ms-auto me-auto mt-5 pb-3">
        <h1 class="text-uppercase fs-2 text-center p-4 bg-blue t-w">s'enregistrer</h1>
        <form class="signin-form edit-user-info ps-5 pe-5 pt-3 pb-2"
            action="<?php $_SERVER['PHP_SELF'] ?>"
            method="POST">
            <!-- FIRST NAME -->
            <div class="mb-4">
                <label class="form-label mb-1 fw-bold"
                    for="full">Nom et prenom *</label>
                <input class="form-control"
                    type="text"
                    name="fullname"
                    id="full">
            </div>
            <!-- USERNAME -->
            <div class="mb-4">
                <label class="form-label mb-1 fw-bold"
                    for="username">Identifiant *</label>
                <input class="form-control"
                    type="text"
                    name="username"
                    id="username">
            </div>
            <!-- PASSWORD -->
            <div class="mb-4">
                <label class="form-label mb-1 fw-bold"
                    for="password">Mot de pass *</label>
                <input class="form-control"
                    type="password"
                    name="password"
                    id="password">
            </div>
            <!-- EMAIL -->
            <div class="mb-4">
                <label class="form-label mb-1 fw-bold"
                    for="email">E-mail *</label>
                <input class="form-control"
                    type="email"
                    name="email"
                    id="email">
            </div>
            <button class="text-uppercase modal__btn mt-4"
                type="submit">s'enregistrer</button>
        </form>
        <div class="mt-4 ps-5 ps-5">
            <p>vous avez déjat un compte ? <a class="text-uppercase"
                    href="login.php">Se Connecter</a></p>
        </div>
    </div>
</div>

<?php
include $tpl . "footer.php";
ob_end_flush()
    ?>