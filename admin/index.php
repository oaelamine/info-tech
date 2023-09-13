<?php
    session_start();
    $noNavbar = '';
    $pageTitle = 'Login';

    if (isset($_SESSION['Username'])) {
        header('Location: dashboard.php');
    }


    include "init.php";


    //CHEST IF USER COMING FROM HTTP REQUEST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $username = $_POST['user'];
        $pasword = $_POST['pass'];

        //HASHE THE PASSWORD
        $hasheedpass = sha1($pasword);

        //SERCH FOR ADMINS IN THE DB GroupID = 1
        $stmt = $db->prepare("SELECT 
                                    UserID, Username, Password 
                            FROM 
                                users 
                            WHERE 
                                Username = ? 
                            AND 
                                Password = ? 
                            AND 
                                GroupID = 1
                            LIMIT 1
                            ");
        $stmt->execute([$username, $hasheedpass]);
        $row = $stmt->fetch();

        //THE COUNT OF THE ROWS FOUND IN THE DATABASE
        $count = $stmt->rowCount();

        if($count > 0){
            
            //CREATE THE SESSION
            $_SESSION['Username'] = $username;
            $_SESSION['UserID'] = $row['UserID'];
            header('Location: dashboard.php');
        }
    }
?>
    <form class="login p-5 rounded-3 shadow-lg" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <h3 class="text-center w-100 mb-5">Admin</h3>
        <input class="form-control mb-4 p-3 border-bottom border-0" type="text" name="user" id="" placeholder="Username" autocomplete="off">
        <input class="form-control mb-4 p-3 border-bottom border-0" type="password" name="pass" id="" placeholder="Password" autocomplete="new-password">
        <input class="btn btn-primary d-block w-100 rounded-pill" type="submit" value="LOG IN">
    </form>
<?php include $tpl."footer.php"; ?>


