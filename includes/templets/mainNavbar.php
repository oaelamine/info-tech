<nav class="navbar navbar-expand-lg navbar-light p-0 ">
  <div class="container">
    <a class="navbar-brand" href="#"><?php echo lang('ADMIN_HOME') ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse w-100" id="navbarNavDropdown">
      <ul class="navbar-nav flex-grow-1">
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo lang('CATEGORIES') ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo lang('ITEMS') ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="members.php"><?php echo lang('MEMBERS') ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo lang('STATISTICS') ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo lang('LOGS') ?></a>
        </li>
        <li class="nav-item dropdown ms-auto">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php echo lang('ADMIN_NAME') ?>
          </a>
          <ul class="dropdown-menu m-0 p-0 rounded-0" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['UserID'] ?>">Edit Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
