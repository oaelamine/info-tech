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
 * FUNCTION SELECT THE LASTE 5 ITEMS IN THE DB V1.0
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
 * FUNCTION TO GET THE CATEGORYSE
 * 
 */

function getCats()
{
    global $db;
    $stmt = $db->prepare("  SELECT 
                                Name 
                            FROM 
                                cartegories
                            ORDER BY
                                Ordering
                            ASC
                        ");
    $stmt->execute();
    $row = $stmt->fetchAll();

    return $row;
}

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