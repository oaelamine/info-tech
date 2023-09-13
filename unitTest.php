<?php




?>

<!-- SMARTPHONES -->
<div class="row align-items-center mt-3 operations__tab__content operations__content--2 ">
    <?php if (empty($smartItems)) { ?>
        <div style="height: 338px;"
            class="mt-3">
            <h4 class="col- text-center mt-3">PAS DE SMARTPHONES</h4>
        </div>
    <?php } ?>
    <?php foreach ($smartItems as $smartItem) { ?>
        <div class="prod col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-3">
            <div class="card border">
                <div class="card--img w-100">
                    <img class=""
                        src="<?php echo "admin/" . $smartItem['Image'] . "main.png" ?>"
                        alt="">
                </div>
                <div class="card-body">
                    <a href="#"
                        class="card--name mb-0">SMARTPHONES <?php echo $smartItem['Name'] ?></a>
                    <span class="price mb-2 d-block">
                        <bdi class="fw-900">
                            <?php echo $smartItem['Price'] ?>
                        </bdi>
                        <span class="fw-900"> د.ج</span>
                    </span>
                    <div class="mt-3 d-flex align-items-center">
                        <span class="fw-900 d-block flex-fill">Lire plus</span>
                        <a href="articleInfo.php?id=<?php echo $smartItem['ItemID'] ?>">
                            <i class="fa-solid fa-arrow-right t-b   "></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<!-- SMARTPHONES -->
<!-- ACCESSOIRE -->
<div class="row align-items-center mt-3 operations__tab__content operations__content--3 ">
    <?php if (empty($accItems)) { ?>
        <div style="height: 338px;"
            class="mt-3">
            <h4 class="col- text-center mt-3">PAS D'ACCESSOIRE</h4>
        </div>
    <?php } ?>
    <?php foreach ($accItems as $accItem) { ?>
        <div class="prod col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-3">
            <div class="card border">
                <div class="card--img w-100">
                    <img class=""
                        src="<?php echo "admin/" . $accItem['Image'] . "main.png" ?>"
                        alt="">
                </div>
                <div class="card-body">
                    <a href="#"
                        class="card--name mb-0">ACCESSOIRE <?php echo $accItem['Name'] ?></a>
                    <span class="price mb-2 d-block">
                        <bdi class="fw-900">
                            <?php echo $accItem['Price'] ?>
                        </bdi>
                        <span class="fw-900"> د.ج</span>
                    </span>
                    <div class="mt-3 d-flex align-items-center">
                        <span class="fw-900 d-block flex-fill">Lire plus</span>
                        <a href="articleInfo.php?id=<?php echo $accItem['ItemID'] ?>">
                            <i class="fa-solid fa-arrow-right t-b   "></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<!-- SMARTPHONES -->