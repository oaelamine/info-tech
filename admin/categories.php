<?php

/*
========================================================
===                                                  ===
===               CATEGORIE PAGE                     ===
===                                                  ===
========================================================
*/

session_start();

$pageTitle = 'Categories';

if (isset($_SESSION['Username'])) { // CHESK IF THE SESSION IS SET

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // GET THE VALUE OF THE DO AND THEN LOAD THE PAGE

    if ($do == 'Manage') {

        $sort = 'ASC';
        $sorting_option = ['ASC', 'DESC'];

        if (isset($_GET['sort']) && in_array($_GET['sort'], $sorting_option)) {
            $sort = $_GET['sort'];
        }

        $stmt = $db->prepare("SELECT * FROM cartegories ORDER BY Ordering $sort");
        $stmt->execute();
        $categs = $stmt->fetchAll();

        if(!empty($categs)){ ?>
            <div class="container content p-5">
                <h1 class="position-relative fs-3 fw-bold">Categories</h1>
                <div class="mt-5">
                    <div class="plan">
                        <div class="top rounded-3 d-flex align-items-center justify-content-between">
                            <h2 class="text-start p-4">Gestion des categorie</h2>
                            <div class="sorting p-4">
                                <a href="?sort=ASC"
                                    class="p-2 rounded-3 <?php if ($sort == 'ASC')
                                        echo 'sort_active'; ?>"><i class="fa-solid fa-arrow-up"></i></a>
                                <a href="?sort=DESC"
                                    class="p-2 rounded-3 <?php if ($sort == 'DESC')
                                        echo 'sort_active'; ?>"><i class="fa-solid fa-arrow-down"></i></a>
                            </div>
                        </div>
                        <ul class="rounded-3">
                            <?php
                            foreach ($categs as $categ) {
                                echo '<li class="cate_li d-flex align-items-center justify-content-between border-bottom overflow-hidden">';
                                echo "<div class='p-3 d-flex flex-column align-items-start justify-content-center'>";
                                echo '<span class="d-block mt-2 mb-2 fs-5 cat_name">' . $categ['Name'] . '</span>';
                                if ($categ['Discription'] != '')
                                    echo '<P class="cat_disc">' . $categ['Discription'] . '</P>';
                                echo '<div class="d-flex">'; //OPTION DEV START
                                if ($categ['Visibility'] == 1)
                                    echo '<span class="cat_visibil me-2 rounded-3">cachée</span>';
                                if ($categ['Allow_Comment'] == 1)
                                    echo '<span class="cat_comment me-2 rounded-3">Commentaire désactivé</span>';
                                if ($categ['Allow_Ads'] == 1)
                                    echo '<span class="cat_ads me-2 rounded-3">ADS désactivé</span>';
                                echo '</div>'; //OPTION DEV END
                                echo "</div>";
                                echo "<div class='p-3 option-buttons position-relative'>"; //EDIT/DELETE DEV START
                                echo "<span class='btn btn-success ms-1'><a href='categories.php?do=Edit&id=" . $categ['ID'] . "'><i class='fa-solid fa-pen-to-square fs-5'></i></a></span>";
                                echo "<span class='btn btn-danger ms-1'><a href='categories.php?do=Delete&id=" . $categ['ID'] . "' class='confirmCatDelete'><i class='fa-solid fa-xmark fs-5'></i></a></span>";
                                echo "</div>"; //EDIT/DELETE DEV START
                                echo '</li>';
                            };
                            ?>
                        </ul>
                    </div>
                    <a href="categories.php?do=Add"
                    class="btn btn-primary mt-4 mb-5"><i class="fa fa-plus"></i> Nouvelle Categorie</a>
                </div>
            </div>
        <?php } else { ?>
            <div class="container content p-5">
                <h1 class="position-relative fs-3 fw-bold">Categories</h1>
                <div class="alert no_catg mt-5 bg-light p-4 position-relative" role="alert">PAS DE <strong>CATEGORIE</strong></div>
                <a href="categories.php?do=Add"
                        class="btn btn-primary mt-4 mb-5"><i class="fa fa-plus"></i> Nouvelle Categorie</a>
            </div>
        <?php }             

    } elseif ($do == "Add") {

        ?>

        <div class="container content p-5">
            <h1 class="position-relative fs-3 fw-bold">Ajouté Categorie</h1>
            <div class="container d-flex justify-content-center align-items-center mt-5">
                <form class="add_member w-50 ms-auto me-auto"
                    action="?do=Insert"
                    method='POST'>
                    <div class="col-sm-12 mb-3">
                        <input type="text"
                            class="form-control border-0 border-bottom border-2 rounded-0 p-3"
                            id="name"
                            placeholder="Name"
                            name="name"
                            autocomplete="off"
                            required='required'>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <input type="text"
                            class="password form-control border-0 border-bottom border-2 rounded-0 p-3"
                            id="description"
                            placeholder="Description"
                            name="description"
                            autocomplete="off">
                    </div>
                    <div class="col-sm-12 mb-3">
                        <input type="text"
                            class="form-control border-0 border-bottom border-2 rounded-0 p-3"
                            id="ordering"
                            placeholder="The order the categorie"
                            name="ordering"
                            autocomplete="off">
                    </div>
                    <!-- VISIBILITY  -->
                    <div class="col-sm-12 mb-3">
                        <label>Visibilety</label>
                        <div>
                            <input type="radio"
                                id="visibleY"
                                name="visibilety"
                                value="0"
                                checked>
                            <label for="visibleY">Yes</label>
                        </div>
                        <div>
                            <input type="radio"
                                id="visibleN"
                                name="visibilety"
                                value="1">
                            <label for="visibleN">No</label>
                        </div>
                    </div>
                    <!-- COMMENTING  -->
                    <div class="col-sm-12 mb-3">
                        <label>Commenting</label>
                        <div>
                            <input type="radio"
                                id="commentY"
                                name="commenting"
                                value="0"
                                checked>
                            <label for="commentY">Yes</label>
                        </div>
                        <div>
                            <input type="radio"
                                id="commentN"
                                name="commenting"
                                value="1">
                            <label for="commentN">No</label>
                        </div>
                    </div>
                    <!-- COMMENTING  -->
                    <div class="col-sm-12 mb-3">
                        <label>Ads</label>
                        <div>
                            <input type="radio"
                                id="adsY"
                                name="ads"
                                value="0"
                                checked>
                            <label for="adsY">Yes</label>
                        </div>
                        <div>
                            <input type="radio"
                                id="adsN"
                                name="ads"
                                value="1">
                            <label for="adsN">No</label>
                        </div>
                    </div>
                    <button type="submit"
                        class="btn btn-primary rounded-pill w-100 mt-3">Add Categories</button>
                </form>
            </div>
        </div>

        <?php

    } elseif ($do == "Insert") {

        echo '<div class="container mt-5">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //GET DATA FROM POST REQUEST
            $name = $_POST['name'];
            $description = $_POST['description'];
            $ordering = $_POST['ordering'];
            $visibilety = $_POST['visibilety'];
            $commenting = $_POST['commenting'];
            $ads = $_POST['ads'];


            $check = chackItem('Name', 'cartegories', $name);
            if ($check == 0) {

                $stmt = $db->prepare("INSERT INTO 
                                        cartegories (Name, Discription, Ordering, Visibility, Allow_Comment, Allow_Ads) 
                                        VALUES (:Name, :Discription, :Ordering, :Visibility, :Allow_Comment, :Allow_Ads)");
                $stmt->execute([
                    'Name' => $name,
                    'Discription' => $description,
                    'Ordering' => $ordering,
                    'Visibility' => $visibilety,
                    'Allow_Comment' => $commenting,
                    'Allow_Ads' => $ads
                ]);

                $count = $stmt->rowCount();

                if ($count > 0) {
                    $Msg = '<div class="alert alert-success text-center" role="alert">Categorie INSERTED !!</div>';
                    redirectHome($Msg, 3, 'categories.php');
                } else {
                    $Msg = '<div class="alert alert-danger text-center" role="alert">A PROBLEM HASS ACURE</div>';
                    redirectHome($Msg, 3, 'categories.php');
                }
                ;

            } else {
                $Msg = '<div class="alert alert-danger text-center" role="alert">THIS CATEGORIE ALREDY EXIST</div>';
                redirectHome($Msg, 3, 'categories.php');
            }

        } else {
            $Msg = "<div class='alert alert-danger text-center'>YOU CANT ACCESS THIS PAGE DIRECTLY</div>";
            redirectHome($Msg, 3, 'back');
        }
        echo '</div>';

    } elseif ($do == "Edit") {

        ?>
        <div class="container content p-5">
            <h1 class="position-relative fs-3 fw-bold">Modifier Categorie</h1>
            <div class="mt-5">
                <?php
                $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

                $stmt = $db->prepare("SELECT * FROM cartegories WHERE ID = ?");
                $stmt->execute([$id]);
                $row = $stmt->fetch();
                $count = $stmt->rowCount();


                if ($count > 0) { ?>
                    <div class="container d-flex justify-content-center align-items-center mt-5">
                        <form class="add_member w-50 ms-auto me-auto"
                            action="?do=Update"
                            method='POST'>
                            <input type="text"
                                hidden
                                name="id"
                                value="<?php echo $id ?>">
                            <div class="col-sm-12 mb-3">
                                <input type="text"
                                    class="form-control border-0 border-bottom border-2 rounded-0 p-3"
                                    id="name"
                                    placeholder="Name"
                                    name="name"
                                    required='required'
                                    value="<?php echo $row['Name'] ?>">
                            </div>
                            <div class="col-sm-12 mb-3">
                                <input type="text"
                                    class="password form-control border-0 border-bottom border-2 rounded-0 p-3"
                                    id="description"
                                    placeholder="Description"
                                    name="description"
                                    value="<?php echo $row['Discription'] ?>">
                            </div>
                            <div class="col-sm-12 mb-3">
                                <input type="text"
                                    class="form-control border-0 border-bottom border-2 rounded-0 p-3"
                                    id="ordering"
                                    placeholder="The order the categorie"
                                    name="ordering"
                                    value="<?php echo $row['Ordering'] ?>">
                            </div>
                            <!-- VISIBILITY  -->
                            <div class="col-sm-12 mb-3">
                                <label>Visibilety</label>
                                <div>
                                    <input type="radio"
                                        id="visibleY"
                                        name="visibilety"
                                        value="0"
                                        <?php if($row['Visibility'] == '0') echo 'checked' ?>
                                        >
                                    <label for="visibleY">Yes</label>
                                </div>
                                <div>
                                    <input type="radio"
                                        id="visibleN"
                                        name="visibilety"
                                        value="1"
                                        <?php if($row['Visibility'] == '1') echo 'checked' ?>
                                        >
                                    <label for="visibleN">No</label>
                                </div>
                            </div>
                            <!-- COMMENTING  -->
                            <div class="col-sm-12 mb-3">
                                <label>Commenting</label>
                                <div>
                                    <input type="radio"
                                        id="commentY"
                                        name="commenting"
                                        value="0"
                                        <?php if($row['Allow_Comment'] == '0') echo 'checked' ?>>
                                    <label for="commentY">Yes</label>
                                </div>
                                <div>
                                    <input type="radio"
                                        id="commentN"
                                        name="commenting"
                                        value="1"
                                        <?php if($row['Allow_Comment'] == '1') echo 'checked' ?>>
                                    <label for="commentN">No</label>
                                </div>
                            </div>
                            <!-- COMMENTING  -->
                            <div class="col-sm-12 mb-3">
                                <label>Ads</label>
                                <div>
                                    <input type="radio"
                                        id="adsY"
                                        name="ads"
                                        value="0"
                                        <?php if($row['Allow_Ads'] == '0') echo 'checked' ?>>
                                    <label for="adsY">Yes</label>
                                </div>
                                <div>
                                    <input type="radio"
                                        id="adsN"
                                        name="ads"
                                        value="1"
                                        <?php if($row['Allow_Ads'] == '1') echo 'checked' ?>>
                                    <label for="adsN">No</label>
                                </div>
                            </div>
                            <button type="submit"
                                class="btn btn-primary rounded-pill w-100 mt-3">Modifier</button>
                        </form>
                    </div>
                    <?php
                } else {
                    echo "<div class='container mt-5'>";
                    $Msg = "<div class='alert alert-danger text-center'>UserID not found</div>";
                    redirectHome($Msg, 3);
                    echo "</div>";
                } ?>
            </div>
        </div>
        <?php

    } elseif ($do == "Update") {
        echo '<div class="container mt-5">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $ordering = $_POST['ordering'];
            $visibilety = $_POST['visibilety'];
            $Allow_Comment = $_POST['commenting'];
            $Allow_Ads = $_POST['ads'];

            $check = chackItem('ID', 'cartegories', $id);

            // CHESK IF THER IS NO ERRORS THEN UPDATE THE DB
            if ($check > 0) {
                //update the db with this info
                $stmt = $db->prepare("UPDATE
                                            cartegories
                                        SET
                                            Name = ?,
                                            Discription = ?,
                                            Ordering = ?,
                                            Visibility = ?,
                                            Allow_Comment = ?,
                                            Allow_Ads = ?
                                        WHERE
                                            ID = ?
                            
                    ");
                $stmt->execute([$name, $description, $ordering, $visibilety, $Allow_Comment, $Allow_Ads, $id]);

                //CHESK IF THE DB HASE BEN UPDATED
                $count = $stmt->rowCount();

                if ($count > 0) {
                    $Msg = '<div class="alert alert-success text-center" role="alert">INFO ENREGISTRER</div>';
                    redirectHome($Msg, 3, 'back');
                } else {
                    $Msg = '<div class="alert alert-danger text-center" role="alert">INFO NON ENREGISTRER</div>';
                    redirectHome($Msg, 3, 'back');
                };
            }
        } else {
            $Msg = '<div class="alert alert-danger text-center" role="alert">YOU CANT ACCESS THIS PAGE</div>';
            redirectHome($Msg, 3, 'categories.php');
        }
        echo '<div/>';

    } elseif ($do == "Delete") {
        echo '<div class="container mt-5">';
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        ;

        //CHESK IF THER IS A USER WITH THIS ID
        $chesk = chackItem('id', 'cartegories', $id);

        if ($chesk > 0) {
            $stmt = $db->prepare("DELETE FROM cartegories WHERE ID = ?");
            $stmt->execute([$id]);
            $Msg = '<div class="alert alert-danger text-center" role="alert">CATEGORIE SUPPRIMER !!!</div>';
            redirectHome($Msg, 3, 'categories.php');

        } else {
            $Msg = '<div class="alert alert-primary text-center" role="alert">ID N\'EXIST PAS !!!</div>';
            redirectHome($Msg, 3, 'categories.php');
        }
        echo '</div>';
    }
    ;

    include $tpl . 'footer.php';
} else {
    header('Location: index.php'); //   redirect to index if ther is no do=
    exit();
}

?>