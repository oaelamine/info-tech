<?php

/* 
 * FUNCTION TO CHANGE THE TITEL OF THE CURRENT PAGE IN THE BROWSER TAB V1
 */
function gatTitel()
{
    global $pageTitle;
    if (isset($pageTitle)) {
        echo $pageTitle;
    } else {
        echo 'Default';
    }
}

/* 
 * FUNCTION TO REDIRECT THE USER TO THE HOME PAGE V1.0
 * THE FUNCTION ACCEPT 2 ARGUMENT [ THE MESSAGE, AND THE TIME AFTER WICHE YOU WELL BE REDIRECTED TO THE PAGE, PAGE URL]
 */

function redirectHome($Msg, $secends = 3, $url = null)
{
    if ($url === null) {

        $url = 'index.php';

    } else {

        isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $url = $_SERVER['HTTP_REFERER'] : $url = 'index.php';

    }

    echo $Msg;
    echo "<div class='alert alert-info text-center'>You well be redirected to the home page afrer $secends secends</div>";
    header("refresh:$secends;url=$url");
    exit();
}


/* 
 * FUNCTION TO CHESK ITEMS IN THE DATABASE V1
 * THE FUNCTION ACCEPT ARGUMATS:
 * $COLUMN [ THE NAME OF THE COLUMN IN THE DATABASE ]
 * $TABLE [ THE NAME OF THE TABLE ]
 * $VALUE [ THE CONDITION  ]
 */

function chackItem($column, $table, $value)
{
    global $db;
    $query = $db->prepare("SELECT $column FROM $table WHERE $column = ?");
    $query->execute([$value]);
    $count = $query->rowCount();
    return $count;
}

/* 
 * FUNCTION TO COUNT THE NUMBER OF ITEMS V1.0
 * 
 */
function countItems($item, $table, $where = null, $condition = null)
{
    global $db;

    $stmt = $db->prepare("SELECT COUNT($item) FROM $table $where $condition");
    $stmt->execute();
    $count = $stmt->fetchColumn();

    return $count;
}


/* 
 * FUNCTION TO SELECT THE LASTE 5 ITEMS IN THE DB V1.0
 * 
 */

function lastItems($select, $from, $where = null, $condition, $order, $limit)
{
    global $db;

    $stmt = $db->prepare("SELECT $select FROM $from $where $condition ORDER BY $order DESC LIMIT $limit");
    $stmt->execute();
    $row = $stmt->fetchAll();

    return $row;
}

// =========================================== SHOP FUCTIONS =========================================== //

/* 
 * FUNCTION TO SELECT THE LASTE 1 ITEMS IN THE DB V1.0
 * 
 */
function getLastItemID($select, $from, $order, $limit)
{
    global $db;

    $stmt = $db->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $limit");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row;
}

/* 
 * FUNCTION TO UPLOAD IMAGES
 * 
 */
function uploadImages($id, $mainimg, $pic1img, $pic2img, $pic3img)
{
    global $db;

    // $target_dir = "data/uploades" . $row['ItemID'] . "/"; //chemain du dossier
    $target_dir = "data/uploades/" . $id . "/"; //chemain du dossier
    $target_main = $target_dir . basename('main.png');
    $target_pic1 = $target_dir . basename('1.jpg');
    $target_pic2 = $target_dir . basename('2.jpg');
    $target_pic3 = $target_dir . basename('3.jpg');

    // $uploadOK = 1;


    // $mainimg = $_FILES['mainimg']['tmp_name']; //tmp_name temporary location
    // $pic1img = $_FILES['pic1img']['tmp_name']; //tmp_name temporary location
    // $pic2img = $_FILES['pic2img']['tmp_name']; //tmp_name temporary location
    // $pic3img = $_FILES['pic3img']['tmp_name']; //tmp_name temporary location



    mkdir($target_dir);
    move_uploaded_file($mainimg, $target_main);
    move_uploaded_file($pic1img, $target_pic1);
    move_uploaded_file($pic2img, $target_pic2);
    move_uploaded_file($pic3img, $target_pic3);

    $stmt = $db->prepare("UPDATE items SET Image = ? WHERE ItemID = ?");
    $stmt->execute([$target_dir, $id]);
    $count = $stmt->rowCount();

    return $count;
}

/* 
 * FUNCTION TO DELETE THE FILE THE CONTAINS UPLOAD IMAGES
 * 
 */
function deleteFolder($path)
{
    $files = glob($path . "/*");

    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }

    rmdir($path);
}

/* 
 * FUNCTION TO SELECT ONE USER
 * 
 */

function getOne($id, $from, $where)
{
    global $db;

    $stmt = $db->prepare("SELECT * FROM $from WHERE $where = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row;
}
function getOrderDetails($id)
{
    global $db;

    $stmt = $db->prepare("SELECT * FROM orders_details WHERE OrderID = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetchAll();

    return $row;
}