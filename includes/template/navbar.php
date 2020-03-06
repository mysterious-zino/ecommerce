<?php ob_start(); ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">HOME</a>
  <a class="nav-link" href="admin/index.php">login admin</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#admin" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse " id="admin">
    <ul class="navbar-nav  ml-auto float-right">
      <li class="nav-item">
        
      </li>
      <?php foreach(lastuscat() as $lastus){
            echo '<li class="nav-link"><a href="categories.php?pageid=' . $lastus['cat_id'] . '">' . $lastus['name'] . '</a></li>';

          }
          ?>
    </ul>
  </div>
</nav>
<?php ob_end_flush(); ?>