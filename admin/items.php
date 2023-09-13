<?php
/*
========================================================
===                                                  ===
===               ITEMS PAGE                     ===
===                                                  ===
========================================================
*/
session_start();
$pageTitle = 'Items';
if (isset($_SESSION['Username'])) { // CHESK IF THE SESSION IS SET
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // GET THE VALUE OF THE DO AND THEN LOAD THE PAGE
    if ($do == 'Manage') {

        $stmt = $db->prepare("  SELECT 
                                        items.*, 
                                        cartegories.Name as catname, 
                                        users.Username 
                                FROM 
                                    items
                                INNER JOIN 
                                    cartegories 
                                ON 
                                    cartegories.ID = items.CatID 
                                INNER JOIN 
                                    users 
                                ON 
                                    users.UserID = items.UserID
                                ORDER BY 
                                    ItemID 
                                DESC
                            ");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        if(!empty($rows)){ ?>
            <div class="container content p-5">
                <h1 class="position-relative fs-3 fw-bold">Articles</h1>

                <div class="mt-5">
                    <table class="table text-center main_table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Description</th>
                                <th scope="col">Prix</th>
                                <th scope="col">Date d'ajout</th>
                                <th scope="col">Categorie</th>
                                <th scope="col">User</th>
                                <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rows as $row) {
                                echo "<tr class='items_row'>";
                                echo "<th scope='row'>" . $row['ItemID'] . "</th>";
                                echo "<td class='items_name'>" . $row['Name'] . "</td>";
                                echo "<td class='items_disc'>" . $row['Descreption'] . "</td>";
                                echo "<td>" . $row['Price'] . "</td>";
                                echo "<td>" . $row['Add_Date'] . "</td>";
                                echo "<td>" . $row['catname'] . "</td>";
                                echo "<td>" . $row['Username'] . "</td>";
                                echo "<td>";
                                echo "<a href='items.php?do=Edit&itemid=" . $row['ItemID'] . "' class='btn btn-success me-1 pt-2 pb-1 ps-2 pe-2''><i class='fa-solid fa-pen-to-square  fs-5'></i></a>";
                                echo "<a href='items.php?do=Delete&itemid=" . $row['ItemID'] . "' class='btn btn-danger confirmMembrDelete me-1 pt-2 pb-1 ps-2 pe-2'><i class='fa-solid fa-xmark fs-5'></i></a>";
                                if ($row['Approuve'] == 0) {
                                    echo "<a href='items.php?do=Approuve&itemid=" . $row['ItemID'] . "' class='btn btn-warning me-1 pt-2 pb-1 ps-2 pe-2'><i class='fa-solid fa-check fs-5'></i></a>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <a href="items.php?do=Add"
                        class="btn btn-primary mt-4 mb-5"><i class="fa fa-plus"></i> Nouvelle Article</a>
                </div>
            </div>
        <?php } else { ?>
            <div class="container content p-5">
                <h1 class="position-relative fs-3 fw-bold">Articles</h1>
                <div class="alert no_catg mt-5 bg-light p-4 position-relative" role="alert">PAS D'<strong>ARTICLES</strong></div>
                <a href="items.php?do=Add"
                        class="btn btn-primary mt-4 mb-5"><i class="fa fa-plus"></i> Nouvelle Article</a>
            </div>
        <?php }
    } elseif ($do == "Add") {
        ?>

        <div class="container content p-5">
            <h1 class="position-relative fs-3 fw-bold">Ajouté un article</h1>
            <div class="container d-flex justify-content-center align-items-center mt-5">
                <form class="add_member w-50 ms-auto me-auto"
                    action="?do=Insert"
                    method='POST'
                    enctype="multipart/form-data">
                    <!-- name -->
                    <div class="col-sm-12 mb-3">
                        <input type="text"
                            class="form-control border-0 border-bottom border-2 rounded-0 p-3"
                            id="name"
                            placeholder="nan de l'article"
                            name="name"
                            autocomplete="off"
                            required='required'>
                    </div>
                    <!-- description -->
                    <div class="col-sm-12 mb-3">
                        <input type="text"
                            class="password form-control border-0 border-bottom border-2 rounded-0 p-3"
                            id="description"
                            placeholder="Description de l'article"
                            name="description"
                            autocomplete="off">
                    </div>
                    <!-- price -->
                    <div class="col-sm-12 mb-4">
                        <input type="text"
                            class="form-control border-0 border-bottom border-2 rounded-0 p-3"
                            id="price"
                            placeholder="Price"
                            name="price"
                            autocomplete="off">
                    </div>
                    <div class="col-sm-12 mb-4 d-flex align-items-center justify-content-around">
                        <div>
                            <label for="cat">Categorie</label>
                            <select name="cat"
                                id="cat">
                                <?php
                                $stmt = $db->prepare("SELECT * FROM cartegories");
                                $stmt->execute();
                                $catgs = $stmt->fetchAll();
                                foreach ($catgs as $catg) {
                                    echo '<option value="' . $catg['ID'] . '">' . $catg['Name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="user">User</label>
                            <select name="user"
                                id="user">
                                <?php
                                $stmt = $db->prepare("SELECT * FROM users");
                                $stmt->execute();
                                $names = $stmt->fetchAll();
                                foreach ($names as $name) {
                                    echo '<option value="' . $name['UserID'] . '">' . $name['Username'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- UPLOAD IMAGES -->
                    <div class="text-center col-sm-12 mb-4">
                        <label class="d-block mb-3" for="mainimg">Image Principale</label>
                        <input type="file" name="mainimg" id="mainimg">
                    </div>
                    <div class="text-center col-sm-12 mb-4">
                        <label class="d-block mb-3" for="secimg">Images secondaires</label>
                        <input type="file" name="pic1img" id="secimg">
                        <input type="file" name="pic2img" id="secimg">
                        <input type="file" name="pic3img" id="secimg">
                    </div>
                    <button type="submit"
                        class="btn btn-primary rounded-pill w-100 mt-3">Ajouter L'article</button>
                </form>
            </div>
        </div>

        <?php
    } elseif ($do == "Insert") {
        echo '<div class="container mt-5">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $cat = $_POST['cat'];
            $userid = $_POST['user'];

            // IMAGES TEMP PATH
            $mainimg = $_FILES['mainimg']['tmp_name']; //tmp_name temporary location
            $pic1img = $_FILES['pic1img']['tmp_name']; //tmp_name temporary location
            $pic2img = $_FILES['pic2img']['tmp_name']; //tmp_name temporary location
            $pic3img = $_FILES['pic3img']['tmp_name']; //tmp_name temporary location


            //FROM VALIDATION
            $formErrors = [];
            if (empty($name)) {
                $formErrors[] = 'Le champ de nom ne peut pas être <strong>vide</strong>';
            }
            if (empty($description)) {
                $formErrors[] = 'Le champ de description ne peut pas être <strong>vide</strong>';
            }
            ;
            if (empty($price)) {
                $formErrors[] = 'Le champ de prix ne peut pas être <strong>vide</strong>';
            }
            ;
            if ($cat == 0) {
                $formErrors[] = 'Il faut choisire une <strong>categorie</strong>';
            }
            ;
            if ($userid == 0) {
                $formErrors[] = 'Il faut choisire un <strong>utilisateur</strong>';
            }
            ;

            //echo the eroors
            foreach ($formErrors as $error) {
                echo '<div class="alert alert-danger text-center" role="alert">' . $error . '</div>';
            }
            ;

            //CHESK IF THER IS NO ERRORS AND INSERT THE NEW MEMBER
            if (empty($formErrors)) {
                $itemCount = chackItem('name', 'items', $name);
                if ($itemCount == 0) {
                    $stmt = $db->prepare("INSERT INTO 
                                                    items (Name, Descreption, Price, Add_Date, CatID, UserID) 
                                                    VALUES (:Name, :Descreption, :Price, now(), :cat, :userid)");

                    $stmt->execute([
                        'Name' => $name,
                        'Descreption' => $description,
                        'Price' => $price,
                        'cat' => $cat,
                        'userid' => $userid
                    ]);

                    //CHESK IF THE DB HASE BEN UPDATED
                    $count = $stmt->rowCount();

                    if ($count > 0) {
                        //SELECT THE LAST ITEM
                        $insertID = getLastItemID('ItemID', 'items', 'ItemID', 1);
                        //DIR PATH
                        // $target_dir = "data/uploades/".$insertID['ItemID']."/"; 

                        //insert the path in the db
                        if (isset($insertID)) {
                            $count = uploadImages($insertID['ItemID'], $mainimg, $pic1img, $pic2img, $pic3img);
                            // $stmt = $db->prepare("INSERT INTO items (Image) VALUES (:image)");
                            // $stmt->execute(['image' => $target_dir]);
                            // $count = $stmt->rowCount();
                            if ($count > 0) {
                                $Msg = '<div class="alert alert-success text-center" role="alert">ARTICLE AJOUTER !!</div>';
                                redirectHome($Msg, 5, 'items.php');
                            }
                        }
                        // $Msg = '<div class="alert alert-success text-center" role="alert">ARTICLE AJOUTER !!</div>';
                        // redirectHome($Msg, 5, 'items.php');
                    } else {
                        $Msg = '<div class="alert alert-danger text-center" role="alert">IL Y A UN PROBLEM</div>';
                        redirectHome($Msg, 5, 'items.php');
                    }
                    ;
                } else {
                    $Msg = "<div class='alert alert-danger text-center'>This item Alredy Existe</div>";
                    redirectHome($Msg, 5);
                }
            }

        } else {
            $Msg = "<div class='alert alert-danger text-center'>YOU CANT ACCESS THIS PAGE DIRECTLY</div>";
            redirectHome($Msg, 3, 'back');
        }
        ;
        echo '</div>';
    } elseif ($do == "Edit") {

        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;


        $stmt = $db->prepare("SELECT * FROM items WHERE ItemID = ?");
        $stmt->execute([$itemid]);
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) { ?>

            <div class="container content p-5">
                <h1 class="position-relative fs-3 fw-bold">Modifer l'article</h1>
                <div class="container d-flex justify-content-center align-items-center mt-5">
                    <form class="add_member w-50 ms-auto me-auto"
                        action="?do=Update"
                        method='POST'>
                        <!-- itemd id  -->
                        <input type="text"
                            name="itemid"
                            id="itemid"
                            value="<?php echo $row['ItemID'] ?>"
                            hidden>
                        <!-- name -->
                        <div class="col-sm-12 mb-3">
                            <input type="text"
                                class="form-control border-0 border-bottom border-2 rounded-0 p-3"
                                id="name"
                                placeholder="nan de l'article"
                                name="name"
                                autocomplete="off"
                                required='required'
                                value="<?php echo $row['Name'] ?>">
                        </div>
                        <!-- description -->
                        <div class="col-sm-12 mb-3">
                            <input type="text"
                                class="password form-control border-0 border-bottom border-2 rounded-0 p-3"
                                id="description"
                                placeholder="Description de l'article"
                                name="description"
                                autocomplete="off"
                                value="<?php echo $row['Descreption'] ?>">
                        </div>
                        <!-- price -->
                        <div class="col-sm-12 mb-3">
                            <input type="text"
                                class="form-control border-0 border-bottom border-2 rounded-0 p-3"
                                id="price"
                                placeholder="Price"
                                name="price"
                                autocomplete="off"
                                value="<?php echo $row['Price'] ?>">
                        </div>
                        <div class="col-sm-12 mb-3 d-flex align-items-center justify-content-around">
                            <div>
                                <label for="cat">Categorie</label>
                                <select name="cat"
                                    id="cat">
                                    <?php
                                    $stmt = $db->prepare("SELECT * FROM cartegories");
                                    $stmt->execute();
                                    $catgs = $stmt->fetchAll();
                                    foreach ($catgs as $catg) {?>
                                        <option value="<?php echo $catg['ID'] ?>"
                                            <?php if ($catg['ID'] == $row['CatID'])
                                                echo 'selected'; ?>> <?php echo $catg['Name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div>
                                <label for="user">User</label>
                                <select name="user"
                                    id="user">
                                    <?php
                                    $stmt = $db->prepare("SELECT * FROM users");
                                    $stmt->execute();
                                    $names = $stmt->fetchAll();
                                    foreach ($names as $name) { ?>
                                        <option value="<?php echo $name['UserID'] ?>"
                                            <?php if ($name['UserID'] == $row['UserID'])
                                                echo 'selected'; ?>> <?php echo $name['Username'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <button type="submit"
                            class="btn btn-primary rounded-pill w-100 mt-3">Save</button>
                    </form>
                </div>
            </div>


        <?php } else {
            echo "<div class='container mt-5'>";
            $Msg = "<div class='alert alert-danger text-center'>ItemID not found</div>";
            redirectHome($Msg, 5, 'back');
            echo "</div>";
        }

    } elseif ($do == "Update") {
        echo '<div class="container mt-5">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $itemid = $_POST['itemid'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $cat = $_POST['cat'];
            $user = $_POST['user'];

            //FROM VALIDATION
            $formErrors = [];
            if (empty($name)) {
                $formErrors[] = 'Le champ de nom ne peut pas être <strong>vide</strong>';
            }
            if (empty($description)) {
                $formErrors[] = 'Le champ de description ne peut pas être <strong>vide</strong>';
            }
            if (empty($price)) {
                $formErrors[] = 'Le champ de prix ne peut pas être <strong>vide</strong>';
            }
            if ($cat == 0) {
                $formErrors[] = 'Il faut choisire une <strong>categorie</strong>';
            }
            if ($itemid == 0) {
                $formErrors[] = 'Il faut choisire un <strong>utilisateur</strong>';
            }

            //echo the eroors
            foreach ($formErrors as $error) {
                    echo '<div class="alert alert-danger text-center" role="alert">' . $error . '</div>';
                }

            if(empty($formErrors)){
                $check = chackItem('ItemID', 'items', $itemid);

                if ($check > 0) {
                    $stmt = $db->prepare("  UPDATE
                                                items
                                            SET
                                                Name = ?,
                                                Descreption = ?,
                                                Price = ?,
                                                CatID  = ?,
                                                UserID  = ?
                                            WHERE
                                                ItemID  = ?
                                            ");
                
                $stmt->execute([$name, $description, $price, $cat, $user, $itemid]);
                $count = $stmt->rowCount();
                    if ($count > 0) {
                        $Msg = '<div class="alert alert-success text-center" role="alert">INFO ENREGISTRER</div>';
                        redirectHome($Msg, 3, 'back');
                    } else {
                        $Msg = '<div class="alert alert-danger text-center" role="alert">INFO NON ENREGISTRER</div>';
                        redirectHome($Msg, 3, 'back');
                    };
                }
            }
        }
        echo '</div>';
    } elseif ($do == "Delete") {
        echo '<div class="container mt-5">';
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

        $chesk = chackItem('ItemID', 'items', $itemid);

        if ($chesk > 0) {
            $stmt = $db->prepare("DELETE FROM items WHERE ItemID = ?");
            $stmt->execute([$itemid]);
            // DELETE THE IMAGES FOLDER
            $path = "data/uploades/" . $itemid . "/";
            if (isset($path)) {
                deleteFolder($path);
            }
            $Msg = '<div class="alert alert-danger text-center" role="alert">ARTICLE SUPPRIMER !!!</div>';
            redirectHome($Msg, 3, 'items.php');

        } else {
            $Msg = '<div class="alert alert-primary text-center" role="alert">ID N\'EXIST PAS !!!</div>';
            redirectHome($Msg, 3, 'items.php');
        }
        echo '</div>';
    } elseif ($do == "Approuve") {
        echo '<div class="container mt-5">';
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

        
        $check = chackItem('ItemID', 'items', $itemid);
        if ($check > 0) {
            $stmt = $db->prepare("UPDATE items SET Approuve = 1 WHERE ItemID = ?");
            $stmt->execute([$itemid]);
            $Msg = '<div class="alert alert-success text-center" role="alert">Article Approuver !!!</div>';
            redirectHome($Msg, 2, 'back');
        } else {
            $Msg = '<div class="alert alert-danger text-center" role="alert">ID INIXISTANT !!!</div>';
            redirectHome($Msg, 2);
        }
        echo '</div>';
    }
    include $tpl . 'footer.php';
} else {
    header('Location: index.php'); //   redirect to index if ther is no do=
    exit();
}
?>