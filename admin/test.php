<?php

include('init.php');



$rows = lastItems('OrderID, OrderDate, UserID', 'orders', 'WHERE', 'OrderID > 0', 'OrderID', 5);


var_dump($rows)


    ?>

<!-- <?php foreach ($rows as $row) { ?>
    <div class="article_box text-center col-lg-4 col-md-4 col-sm-6">
        <div class="article_image">
            <a href="<?php echo "articleInfo.php?id=" . $row['ItemID'] ?>">
                <img src="<?php echo "admin/" . $row['Image'] . "main.png" ?>"
                    alt="image">
            </a>
        </div>
        <div class="article_text">
            <h3 class="fs-6">
                <?php echo $row['Name'] ?>
            </h3>
            <span class="price d-block mb-3">
                <?php echo $row['Price'] ?><span>دج</span>
            </span>
            <div class="d-flex align-items-center justify-content-center">
                <a href="#"
                    class="text-uppercase modal__btn ps-2 pe-2 pt-1 pb-1 fs-6 me-2">ajouter au panier</a>
                <a href="#">
                    <i class="fa-regular fa-heart fs-4 t-b"></i>
                </a>
            </div>
        </div>
    </div>
<?php } ?> -->


<!-- <a href="<?php echo "articleInfo.php?id=" . $row['ItemID'] ?>"> -->