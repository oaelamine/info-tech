<?php

/*
========================================================
===                                                  ===
===               MEMBERS PAGE                       ===
===                                                  ===
========================================================
*/

session_start();

$pageTitle = 'Members';

if (isset($_SESSION['Username'])) {
    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if ($do == 'Manage') {

        $query = '';
        if (isset($_GET['page']) && $_GET['page'] == 'Pending') {
            $query = 'AND Regstatus = 0';
        }

        $stmt = $db->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC");

        $stmt->execute();
        $rows = $stmt->fetchAll();
        if (!empty($rows)) { ?>
            <div class="container p-5">
                <h1 class="position-relative fs-3 fw-bold mb-5 ">Utilisateurs</h1>
                <table class="table text-center main_table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Registred date</th>
                            <th scope="col">Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($rows as $row) {
                            echo "<tr>";
                            echo "<th scope='row'>" . $row['UserID'] . "</th>";
                            echo "<td>" . $row['Username'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['Fullname'] . "</td>";
                            echo "<td>" . $row['Date'] . "</td>";
                            echo "<td>";
                            echo "<a href='members.php?do=Edit&userid=" . $row['UserID'] . "' class='btn btn-success me-1 pt-2 pb-1 ps-2 pe-2''><i class='fa-solid fa-pen-to-square  fs-5'></i></a>";
                            echo "<a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirmMembrDelete me-1 pt-2 pb-1 ps-2 pe-2'><i class='fa-solid fa-xmark fs-5'></i></a>";
                            if ($row['Regstatus'] == 0) {
                                echo "<a href='members.php?do=Activate&userid=" . $row['UserID'] . "' class='btn btn-warning me-1 pt-2 pb-1 ps-2 pe-2'><i class='fa-solid fa-check fs-5'></i></a>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <a href="members.php?do=Add"
                    class="btn btn-primary mt-4 mb-5"><i class="fa fa-plus"></i> Ajouter</a>
            </div>
        <?php } else { ?>
            <div class="container content p-5">
                <h1 class="position-relative fs-3 fw-bold">Utilisateurs</h1>
                <div class="alert no_catg mt-5 bg-light p-4 position-relative"
                    role="alert">PAS D'<strong>UTILISATEURS</strong></div>
                <a href="members.php?do=Add"
                    class="btn btn-primary mt-4 mb-5"><i class="fa fa-plus"></i> Nouveau Utilisateur</a>
            </div>
        <?php }
    } elseif ($do == 'Add') { ?>
        <div class="container d-flex justify-content-center align-items-center mt-5">
            <form class="add_member w-50 ms-auto me-auto"
                action="?do=Insert"
                method='POST'>
                <h1 class="text-center mb-5">Add New Member</h1>
                <div class="col-sm-12 mb-3">
                    <input type="text"
                        class="form-control border-0 border-bottom border-2 rounded-0 p-3"
                        id="fullname"
                        placeholder="Full Name"
                        name="full"
                        autocomplete="off"
                        required='required'>
                </div>
                <div class="col-sm-12 mb-3">
                    <input type="text"
                        class="password form-control border-0 border-bottom border-2 rounded-0 p-3"
                        id="username"
                        placeholder="User Name"
                        name="username"
                        autocomplete="off"
                        required='required'>
                </div>
                <div class="col-sm-12 mb-3 position-relative">
                    <input type="password"
                        class="form-control border-0 border-bottom border-2 rounded-0 p-3"
                        id="password"
                        name="password"
                        autocomplete="new-password"
                        placeholder="Password"
                        required='required'>
                    <i class="eye fa-solid fa-eye position-absolute"></i>
                </div>
                <div class="col-sm-12 mb-3">
                    <input type="email"
                        class="form-control border-0 border-bottom border-2 rounded-0 p-3"
                        id="email"
                        placeholder="Email"
                        name="email"
                        autocomplete="off"
                        required='required'>
                </div>
                <button type="submit"
                    class="btn btn-primary rounded-pill w-100 mt-3">Add Member</button>
            </form>
        </div>

<?php
    } elseif ($do == 'Insert') {
        echo '<div class="container mt-5">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $username = $_POST['username'];
            $full = $_POST['full'];
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

            //echo the eroors
            foreach ($formErrors as $error) {
                echo '<div class="alert alert-danger text-center" role="alert">' . $error . '</div>';
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
                        $Msg = '<div class="alert alert-success text-center" role="alert">MEMBER INSERTED !!</div>';
                        redirectHome($Msg, 5, 'back');
                    } else {
                        $Msg = '<div class="alert alert-danger text-center" role="alert">A PROBLEM HASS ACURE</div>';
                        redirectHome($Msg, 5, 'back');
                    }
                    ;
                } else {
                    $Msg = "<div class='alert alert-danger text-center'>This Username Alredy Existe</div>";
                    redirectHome($Msg, 5, 'back');
                }
            }

        } else {
            $Msg = "<div class='alert alert-danger text-center'>YOU CANT ACCESS THIS PAGE DIRECTLY</div>";
            redirectHome($Msg, 3);
        }
        ;
        echo '</div>';

    } elseif ($do == 'Edit') {

        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        $stmt = $db->prepare("SELECT * FROM users WHERE UserID = ?");
        $stmt->execute([$userid]);
        $row = $stmt->fetch();
        $count = $stmt->rowCount();


        if ($count > 0) { ?>
        <div class="container d-flex justify-content-center align-items-center mt-5">
            <form class="edit_profile w-50 ms-auto me-auto"
                action="?do=Update"
                method='POST'>
                <h1 class="text-center mb-5">Edit Profile</h1>
                <input type="text"
                    hidden
                    name="userid"
                    value="<?php echo $userid ?>">
                <div class="col-sm-12 mb-3">
                    <input type="text"
                        class="form-control border-0 border-bottom border-2 rounded-0 p-3"
                        id="fullname"
                        placeholder="Full Name"
                        name="full"
                        autocomplete="off"
                        value="<?php echo $row['Fullname'] ?>"
                        required='required'>
                </div>
                <div class="col-sm-12 mb-3">
                    <input type="text"
                        class="form-control border-0 border-bottom border-2 rounded-0 p-3"
                        id="username"
                        placeholder="User Name"
                        name="username"
                        autocomplete="off"
                        value="<?php echo $row['Username'] ?>"
                        required='required'>
                </div>
                <div class="col-sm-12 mb-3">
                    <input type="password"
                        hidden
                        name="oldpassword"
                        value="<?php echo $row['Password'] ?>">
                    <input type="password"
                        class="form-control border-0 border-bottom border-2 rounded-0 p-3"
                        id="password"
                        name="newpassword"
                        autocomplete="new-password"
                        placeholder="Leave it blank if you dont want to change you password">
                </div>
                <div class="col-sm-12 mb-3">
                    <input type="email"
                        class="form-control border-0 border-bottom border-2 rounded-0 p-3"
                        id="email"
                        placeholder="Email"
                        name="email"
                        autocomplete="off"
                        value="<?php echo $row['email'] ?>"
                        required='required'>
                </div>
                <button type="submit"
                    class="btn btn-primary rounded-pill w-100 mt-3">Save</button>
            </form>
        </div>
        <?php
        } else {
            echo "<div class='container mt-5'>";
            $Msg = "<div class='alert alert-danger text-center'>UserID not found</div>";
            redirectHome($Msg, 5);
            echo "</div>";
        }

    } elseif ($do == 'Update') {
        echo '<div class="container mt-5">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['userid'];
            $username = $_POST['username'];
            $full = $_POST['full'];
            $email = $_POST['email'];

            $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);



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
                $formErrors[] = 'User Name cant bee more then 20 charecters';
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
            //echo the eroors
            foreach ($formErrors as $error) {
                echo '<div class="alert alert-danger text-center" role="alert">' . $error . '</div>';
            }
            ;

            // CHESK IF THER IS NO ERRORS THEN UPDATE THE DB
            if (empty($formErrors)) {

                $checkStmt = $db->prepare("    SELECT 
                                                    *
                                                FROM
                                                    users
                                                WHERE
                                                    Username = ?
                                                AND
                                                    UserID != ?
                                            ");
                $checkStmt->execute([$username, $id]);
                $chechCount = $checkStmt->rowCount();

                if ($chechCount > 0) {
                    $Msg = '<div class="alert alert-danger text-center" role="alert">Username <strong>EXISTANT</strong></div>';
                    redirectHome($Msg, 5, 'back');
                } else {
                    //update the db with this info
                    $stmt = $db->prepare("UPDATE
                                                users
                                            SET
                                                Username = ?,
                                                Fullname = ?,
                                                email = ?,
                                                Password = ?
                                            WHERE
                                                UserID = ?
                                
                        ");
                    $stmt->execute([$username, $full, $email, $pass, $id]);

                    //CHESK IF THE DB HASE BEN UPDATED
                    $count = $stmt->rowCount();

                    if ($count > 0) {
                        $Msg = '<div class="alert alert-success text-center" role="alert">YOU INFO HASE BEN UPDATED</div>';
                        redirectHome($Msg, 3, 'back');
                    } else {
                        $Msg = '<div class="alert alert-danger text-center" role="alert">NO INFO HAS BEN UPDATED</div>';
                        redirectHome($Msg, 3, 'back');
                    }
                    ;
                }
            }
        } else {
            $Msg = '<div class="alert alert-danger text-center" role="alert">YOU CANT ACCESS THIS PAGE</div>';
            redirectHome($Msg, 3);
        }
        echo '<div/>';


    } elseif ($do == "Delete") {
        echo '<div class="container mt-5">';
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;


        //CHESK IF THER IS A USER WITH THIS ID
        $chesk = chackItem('userid', 'users', $userid);

        if ($chesk > 0) {
            $stmt = $db->prepare("DELETE FROM users WHERE UserID = ?");
            $stmt->execute([$userid]);
            $Msg = '<div class="alert alert-danger text-center" role="alert">UTILISATEUR SUPPRIMER !!!</div>';
            redirectHome($Msg, 3, 'back');

        } else {
            $Msg = '<div class="alert alert-primary text-center" role="alert">ERREUR !!!</div>';
            redirectHome($Msg, 3, 'back');
        }
        echo '</div>';
    } elseif ($do == "Activate") {
        echo '<div class="container mt-5">';
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        ;

        //CHESK IF THER IS A USER WITH THIS ID
        $chesk = chackItem('userid', 'users', $userid);

        if ($chesk > 0) {
            $stmt = $db->prepare("UPDATE users SET Regstatus = 1 WHERE UserID = ?");
            $stmt->execute([$userid]);
            $Msg = '<div class="alert alert-success text-center" role="alert">COMPTE ACTIVER !!!</div>';
            redirectHome($Msg, 3, 'back');

        } else {
            $Msg = '<div class="alert alert-danger text-center" role="alert">ERREUR !!!</div>';
            redirectHome($Msg, 3);
        }
        echo '</div>';
    }
    ;
    include $tpl . 'footer.php';
} else {
    header('Location: index.php'); //   redirect to index if ther is no do= 
    exit();
}