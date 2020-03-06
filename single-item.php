<?php 
ob_start();
	$title = "profile";
	session_start();

	include "init.php";
	$item_id = isset($_GET["itemid"]) && is_numeric($_GET["itemid"]) ? intval($_GET["itemid"]) : 0 ;

		$stmt_g = $con->prepare("SELECT items.*,categories.name as cat_name , categories.cat_id as cate_id, users.username FROM items INNER JOIN categories ON categories.cat_id = items.cat_id INNER JOIN users ON users.user_id = items.member_id WHERE item_id = ? ");
		$stmt_g->execute(array($item_id));
		$info =$stmt_g->fetch();
		$count = $stmt_g->rowcount();
		echo $info['name'];?>
	 
	

	<h2 class="h1 text-center">item singel</h2>
	<div class="container single">
		<div class="row">
			<div class="col-md-3">
				<img class="img-responsive img-thumbnail" src="layout/images/dani.jpg">
			</div>
			<div class="col-md-9">
				<h3><?php echo  $info['name'] ?></h3>
				<p><?php echo  $info['description'] ?></p>
				<ul class="list-unstyled">
					<li><span>add date  </span>: <?php echo  $info['add_date'] ?></li>
					<li><span>price  </span>: $<?php echo  $info['price'] ?></li>
					<li><span>counrty  </span>: <?php echo  $info['country'] ?></li>
					<li><span>category  </span>: <a href="categories.php?pageid=<?php echo  $info['cate_id'] ?>"><?php echo  $info['cat_name'] ?></a></li>
					<li><span>Add by </span>: <a href="user.php?userid=<?php echo  $info['member_id'] ?>"><?php echo  $info['username'] ?></a></li>
				</ul>
			</div>
		</div>
		<hr class="custom-hr">
		<div class="row">
			<div class="col-md-9 offset-md-3">
				<?php if(isset($_SESSION['username'])){ ?>
					<div class="comment">
						<h2>Add comment</h2>
						<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
							<textarea name="comment" class="form-control"></textarea>
							<input type="submit" name="" value="comment" class="btn btn-primary btn-block">
						</form>
			<?php	if($_SERVER['REQUEST_METHOD'] == 'POST'){
						$comment 	= FILTER_VAR($_POST['comment'],FILTER_SANITIZE_STRING);
						$user 		= $_SESSION['use_id'];
						$item 		= $info['item_id'];
						echo $comment . $user . $item;
						if(!empty($comment)){
							$stmt_in = $con->prepare("INSERT INTO comment(comment, add_date, item_id, user_id)
													VALUES(:z_comment, now(), :z_item_id, :z_user_id) ");
							$stmt_in->execute(array(
									'z_comment' => $comment,
									'z_item_id' => $item,
									'z_user_id' => $user
									));
							$inse = $stmt_in->rowcount();
							
							if($inse > 0){
								echo '<div class="error-id alert alert-success">Add Success</div>';
								redirectpage('','back');
							}else {echo '<div class="error-id alert alert-danger">Update Error</div>';}
						}	
					}	
			  echo '</div>';
				}else { ?>
					<div class="comment">
						<h2><a href="login.php">login</a> or <a href="login.php">register</a> to comment</h2>
						<form>
							<textarea disabled="" class="form-control"></textarea>
							<input type="submit" disabled="" name="" value="comment" class="btn btn-primary btn-block">
						</form>
					</div>
			<?php	} ?>
			</div>
		</div>
		<hr class="custom-hr">	
		 <?php
			$stmt=$con->prepare("SELECT comment.*, users.username FROM comment  INNER JOIN users ON users.user_id = comment.user_id WHERE item_id = ? ORDER BY add_date DESC");
			$stmt->execute(array($item_id));
			$test = $stmt->fetchAll();
			foreach($test as $tes){ ?>
				<div class="add_comment">
					<div class="row ">
					
						<div class="col-md-2">
							<img class="img-fluid img-thumbnail img-avatar" src="layout/images/dani.jpg">
							<h3><?php echo $tes['username']; ?></h3>
						</div>
						<div class="col-md-10"> 
							<p class="lead"><?php echo $tes['comment']; ?></p>
							<span class="lead"><?php echo $tes['add_date']; ?></span>
						</div>
					</div>
				</div>
			<?php	}?>
			
		
	</div>

<?php if($count == 0){ header('location:index.php'); }
	include $templateadmin . "footer.php";
ob_end_flush();
?>