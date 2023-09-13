<div class="sidebar bg-white p-3 position-relative">
  <h3 class="position-relative fw-bold text-center mt-0">ADMIN</h3>
  <ul>
    <li class='text-center position-relative admin_menu text-center'>
      <button class="d-flex p-2 align-items-center w-100"><span class="fs-5 flex-fill">
          <?php echo lang('ADMIN_NAME') ?>
        </span><i class="fa-solid fa-chevron-right"></i></button>
      <ul class="admin_drop_menu position-absolute hide">
        <li><a class="d-block m-0 p-1"
            href="members.php?do=Edit&userid=<?php echo $_SESSION['UserID'] ?>">Modifier Profile</a></li>
        <li><a class="d-block m-0 p-1"
            href="../index.php"
            target="_black">Boutique</a></li>
        <li><a class="d-block m-0 p-1"
            href="#">Option</a></li>
        <li><a class="d-block m-0 p-1"
            href="logout.php">Déconection</a></li>
      </ul>
    </li>
    <li>
      <a class="d-flex align-items-center rounded p-2"
        href="dashboard.php">
        <i class="fa-regular fa-circle-user fa-fw"></i>
        <span>
          <?php echo lang('ADMIN_HOME') ?>
        </span>
      </a>
    </li>
    <li>
      <a class="d-flex align-items-center rounded p-2"
        href="categories.php">
        <i class="fa-regular fa-chart-bar fa-fw"></i>
        <span>
          <?php echo lang('CATEGORIES') ?>
        </span>
      </a>
    </li>
    <li>
      <a class="d-flex align-items-center rounded p-2"
        href="items.php">
        <i class="fa-solid fa-gear fa-fw"></i>
        <span>
          <?php echo lang('ITEMS') ?>
        </span>
      </a>
    </li>
    <li>
      <a class="d-flex align-items-center rounded p-2"
        href="members.php">
        <i class="fa-regular fa-user fa-fw"></i>
        <span>
          <?php echo lang('MEMBERS') ?>
        </span>
      </a>
    </li>
    <li>
      <a class="d-flex align-items-center rounded p-2"
        href="#">
        <i class="fa-solid fa-diagram-project fa-fw"></i>
        <span>
          <?php echo lang('STATISTICS') ?>
        </span>
      </a>
    </li>
    <li>
      <a class="d-flex align-items-center rounded p-2"
        href="comments.php">
        <i class="fa-regular fa-comments"></i>
        <span>
          <?php echo lang('COMMENTS') ?>
        </span>
      </a>
    </li>
    <li>
      <a class="d-flex align-items-center rounded p-2"
        href="orders.php">
        <i class="fa-solid fa-cart-plus"></i>
        <span>
          <?php echo lang('ORDERS') ?>
        </span>
      </a>
    </li>

  </ul>
</div>