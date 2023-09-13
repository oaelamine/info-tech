<form action="<?php $_SERVER['PHP_SELF'] ?>"
    method="POST"
    enctype="multipart/form-data">
    <div class="text-center col-sm-12 mb-4">
        <label for="mainimg">Image Principale</label>
        <input type="file"
            name="mainimg"
            id="mainimg">
    </div>
    <div class="text-center col-sm-12">
        <label for="secimg">Images secondaires</label>
        <input type="file"
            name="pic1img"
            id="secimg">
        <input type="file"
            name="pic2img"
            id="secimg">
        <input type="file"
            name="pic3img"
            id="secimg">
    </div>
    <button type="submit">submit</button>
</form>

<?php

include('init.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // uploadImages(1);
}
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {



//     // $target_dir = "data/uploades" . $row['ItemID'] . "/"; //chemain du dossier
//     $target_dir = "data/uploades/1/"; //chemain du dossier
//     $target_main = $target_dir . basename('main.png');
//     $target_pic1 = $target_dir . basename('1.jpg');
//     $target_pic2 = $target_dir . basename('2.jpg');
//     $target_pic3 = $target_dir . basename('3.jpg');

//     $uploadOK = 1;


//     $mainimg = $_FILES['mainimg']['tmp_name']; //tmp_name temporary location
//     $pic1img = $_FILES['pic1img']['tmp_name']; //tmp_name temporary location
//     $pic2img = $_FILES['pic2img']['tmp_name']; //tmp_name temporary location
//     $pic3img = $_FILES['pic3img']['tmp_name']; //tmp_name temporary location



//     mkdir($target_dir);
//     move_uploaded_file($mainimg, $target_main);
//     move_uploaded_file($pic1img, $target_pic1);
//     move_uploaded_file($pic2img, $target_pic2);
//     move_uploaded_file($pic3img, $target_pic3);


// }



?>