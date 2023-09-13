<?php

include "admin/connect.php"; //connect to the Db
//Routes

$tpl = "includes/templets/"; //templets dir
$lang = "includes/langueges/"; //language dir
$func = "includes/functions/"; //language dir
$css = "layout/css/"; //css dir
$imgs = "layout/imgs/"; //css dir
$js = "layout/js/"; //js dir




//INCLUDE THE IMPORTENT FIELS

include $func . "functions.php";
include $lang . "eng.php";
include $tpl . "header.php";