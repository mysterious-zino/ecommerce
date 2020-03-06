<?php ob_start(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="dashbourd.php">daniels</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#admin" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse " id="admin">
    <ul class="navbar-nav  mr-auto">
      <li class="nav-item ">
        <a class="nav-link" href="dashbourd.php"><?php echo lang('dashbourd'); ?></a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="members.php?daniels=manage"><?php echo lang('user'); ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="categories.php"><?php echo lang('categories'); ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="items.php"><?php echo lang('items'); ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="comments.php"><?php echo lang('comment'); ?></a>
      </li>
      <li class="nav-item dropdown navbar-right">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo lang('more'); ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../index.php">visit site</a>
          <a class="dropdown-item" href="#"><?php echo lang('profile'); ?></a>
          <a class="dropdown-item" href="members.php?daniels=edit&userid=<?php echo $_SESSION['user_id']; ?>"><?php echo lang('setting'); ?></a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php"><?php echo lang('logout'); ?></a>
        </div>
      </li>

    </ul>
  </div>
</nav>
<?php ob_end_flush(); ?>