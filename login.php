<?php
ob_start();
session_start();
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

?>

<div class="container">
    <div class="signin col-lg-6 col-sm-12 ms-auto me-auto mt-5 pb-3">
        <h1 class="text-uppercase fs-2 text-center p-4 bg-blue t-w">Se Connecter</h1>
        <form class="signin-form modal__form ps-5 pe-5 pt-3 pb-2"
            action="<?php $_SERVER['PHP_SELF'] ?>"
            method="POST">
            <!-- USERNAME -->
            <div class="mb-4">
                <label class="form-label mb-1 fw-bold"
                    for="user">Identifiant *</label>
                <input class="form-control"
                    type="text"
                    name="user"
                    id="user">
            </div>
            <!-- PASSWORD -->
            <div class="mb-4">
                <label class="form-label mb-1 fw-bold"
                    for="userpass">Mot de pass *</label>
                <input class="form-control"
                    type="password"
                    name="userpass"
                    id="userpass">
            </div>
            <button class="text-uppercase modal__btn mt-4"
                type="submit">Se Connecter</button>
        </form>
        <div class="mt-4 ps-5 ps-5">
            <p>vous n'avez pas de compte ? <a class="text-uppercase"
                    href="signin.php">S'ENREGISTRER</a></p>
        </div>
    </div>
</div>

<?php include $tpl . "footer.php";
ob_end_flush();
?>