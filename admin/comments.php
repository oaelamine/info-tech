<?php
/*
========================================================
===                                                  ===
===               COMMENTS PAGE                     ===
===                                                  ===
========================================================
*/
session_start();
$pageTitle = 'Categories';
if (isset($_SESSION['Username'])) { // CHESK IF THE SESSION IS SET
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // GET THE VALUE OF THE DO AND THEN LOAD THE PAGE
    if ($do == 'Manage') {
        $query = '';
        if (isset($_GET['page']) && $_GET['page'] == 'Pending') {
            $query = 'AND Regstatus = 0';
        }

        // $stmt = $db->prepare("SELECT * FROM comments");
        $stmt = $db->prepare("  SELECT 
                                    comments.*, 
                                    items.Name, 
                                    users.Username 
                                FROM 
                                    comments
                                INNER JOIN 
                                    items 
                                ON 
                                    items.ItemID = comments.ItemID
                                INNER JOIN 
                                    users 
                                ON 
                                    users.UserID = comments.UserID
                                ORDER BY
                                    C_ID
                                DESC
                                ");

        $stmt->execute();
        $rows = $stmt->fetchAll();
        if (!empty($rows)) { ?>
            <div class="container p-5">
                <h1 class="position-relative fs-3 fw-bold mb-5 ">Commentaire</h1>
                <table class="table text-center main_table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Commentaire</th>
                            <th scope="col">Date d'ajout</th>
                            <th scope="col">User</th>
                            <th scope="col">Article</th>
                            <th scope="col">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($rows as $row) {
                            echo "<tr>";
                            echo "<th scope='row'>" . $row['C_ID'] . "</th>";
                            echo "<td>" . $row['Comment'] . "</td>";
                            echo "<td>" . $row['Comment_Date'] . "</td>";
                            echo "<td>" . $row['Username'] . "</td>";
                            echo "<td>" . $row['Name'] . "</td>";
                            echo "<td>";
                            echo "<a href='comments.php?do=Edit&comid=" . $row['C_ID'] . "' class='btn btn-success me-1 pt-2 pb-1 ps-2 pe-2''><i class='fa-solid fa-pen-to-square  fs-5'></i></a>";
                            echo "<a href='comments.php?do=Delete&comid=" . $row['C_ID'] . "' class='btn btn-danger confirmMembrDelete me-1 pt-2 pb-1 ps-2 pe-2'><i class='fa-solid fa-xmark fs-5'></i></a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="container content p-5">
                <h1 class="position-relative fs-3 fw-bold">Commentaire</h1>
                <div class="alert no_catg mt-5 bg-light p-4 position-relative"
                    role="alert">PAS DE <strong>COMMENTAIRE</strong></div>
            </div>
        <?php }
    } elseif ($do == "Edit") {

        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

        $stmt = $db->prepare("SELECT * FROM comments WHERE C_ID = ?");
        $stmt->execute([$comid]);
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) { ?>
            <div class="container d-flex justify-content-center align-items-center mt-5">
                <form class="edit_profile w-50 ms-auto me-auto"
                    action="?do=Update"
                    method='POST'>
                    <h1 class="text-center mb-5">Modifier le commentaire</h1>
                    <input type="text"
                        hidden
                        name="comid"
                        value="<?php echo $comid ?>">
                    <div class="col-sm-12 mb-3">
                        <textarea class="form-control border-0 border-bottom border-2 rounded-0 p-3"
                            name="comment"
                            id="comment"
                            cols="30"
                            rows="5"><?php echo $row['Comment'] ?></textarea>
                    </div>
                    <button type="submit"
                        class="btn btn-primary rounded-pill w-100 mt-3">Save</button>
                </form>
            </div>
            <?php
        } else {
            echo "<div class='container mt-5'>";
            $Msg = "<div class='alert alert-danger text-center'>ID not found</div>";
            redirectHome($Msg, 5);
            echo "</div>";
        }

    } elseif ($do == "Update") {
        echo '<div class="container mt-5">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $comid = $_POST['comid'];
            $comment = $_POST['comment'];

            $formErrors = [];
            if (empty($comment)) {
                $formErrors[] = 'comment filed cant bee empty';
            }

            foreach ($formErrors as $error) {
                echo '<div class="alert alert-danger text-center" role="alert">' . $error . '</div>';
            }
            ;

            if (empty($formErrors)) {

                $stmt = $db->prepare("UPDATE
                                            comments
                                        SET
                                            Comment = ?
                                        WHERE
                                            C_ID = ?
                            
                    ");
                $stmt->execute([$comment, $comid]);

                //CHESK IF THE DB HASE BEN UPDATED
                $count = $stmt->rowCount();

                if ($count > 0) {
                    $Msg = '<div class="alert alert-success text-center" role="alert">YOUR INFO HASE BEN UPDATED</div>';
                    redirectHome($Msg, 2, 'comments.php');
                } else {
                    $Msg = '<div class="alert alert-danger text-center" role="alert">NO INFO HAS BEN UPDATED</div>';
                    redirectHome($Msg, 2, 'comments.php');
                }
                ;
            }
        } else {
            $Msg = '<div class="alert alert-danger text-center" role="alert">YOU CANT ACCESS THIS PAGE</div>';
            redirectHome($Msg, 2);
        }
    } elseif ($do == "Delete") {
        echo '<div class="container mt-5">';
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

        //CHESK IF THER IS A USER WITH THIS ID
        $chesk = chackItem('C_ID', 'comments', $comid);

        if ($chesk > 0) {
            $stmt = $db->prepare("DELETE FROM comments WHERE C_ID = ?");
            $stmt->execute([$comid]);
            $Msg = '<div class="alert alert-danger text-center" role="alert">COMMONTAIRE SUPPRIMER !!!</div>';
            redirectHome($Msg, 3, 'back');

        } else {
            $Msg = '<div class="alert alert-primary text-center" role="alert">ERREUR !!!</div>';
            redirectHome($Msg, 3, 'back');
        }
        echo '</div>';
    }
    ;
    include $tpl . 'footer.php';
} else {
    header('Location: index.php'); //   redirect to index if ther is no do=
    exit();
}
?>