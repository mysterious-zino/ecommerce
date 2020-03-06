<?php 
ob_start();
	$title = "profile";
	session_start();

	include "init.php";
	$userid = isset($_GET["userid"]) && is_numeric($_GET["userid"]) ? intval($_GET["userid"]) : 0 ;

		$stmt_g = $con->prepare("SELECT * FROM users  WHERE user_id = ?");
		$stmt_g->execute(array($userid));
		$info =$stmt_g->fetch();
		$count = $stmt_g->rowcount();
		?>
	 
	

	<h2 class="h1 text-center">user profile</h2>
	<div class="container single">
		<div class="row">
			<div class="col-md-3">
				<img class="img-responsive img-thumbnail" src="layout/images/dani.jpg">
			</div>
			<div class="col-md-9">
				<h3><?php echo  $info['username'] ?></h3>
				<ul class="list-unstyled">
					<li><span>fullname   </span>: <?php echo  $info['fullname'] ?></li>
					<li><span>email  </span>: <?php echo  $info['email'] ?></li>
					<li><span>truststatus  </span>: <?php echo  $info['truststatus'] ?></li>
					<li><span>date  </span>: <?php echo  $info['date'] ?></li>
					
				</ul>
			</div>
		</div>
	</div>
	<div class="ads block">
		<div class="container">
			<div class="card">
				<div class="card-header bg-success">
					ads
				</div>
				<div class="card-body bg-warning">
					<div class="container">
						<div class="row">
							<?php if(!empty(getitem('member_id' ,$info['user_id'],"app"))){
									foreach(getitem('member_id' ,$info['user_id'], "app") as $ads){
										echo '<div class="col-md-3 col-sm-6">' ;
											echo '<div class="img-thumbnail box-item">' ;
											echo '<span class="price">' . $ads['price'] . '</span>';

											if($ads['approve'] == 0){
											echo '<span class="approve">this item not approve yet</span>';
										}
												echo '<img  class="img-fluid" src="layout/images/dani.jpg">';
												echo '<div class="caption">' ;
													echo  '<h3><a href="single-item.php?itemid=' . $ads['item_id'] . '">' . $ads['name'] . '</a></h3>';
													echo  '<p>' . $ads['description'] . '</p>';
													echo  '<span class="date">' . $ads['add_date'] . '</span>';
												echo '</div>';
											echo '</div>' ;
										echo '</div>';
									}
								}else {
									echo 'No ads';
								}
					 		?>
				 		</div>
					</div>
				</div>
			</div>
		</div>
		<div class="ads block">
		<div class="container">
			<div class="card">
				<div class="card-header bg-success">
					ads
				</div>
				<div class="card-body bg-warning">
					<div class="container">
						<div class="row">
							<?php if(!empty(getitem('member_id' ,$info['user_id']))){
									foreach(getitem('member_id' ,$info['user_id']) as $ads){
										echo '<div class="col-md-3 col-sm-6">' ;
											echo '<div class="img-thumbnail box-item">' ;
											echo '<span class="price">' . $ads['price'] . '</span>';
												echo '<img  class="img-fluid" src="layout/images/dani.jpg">';
												echo '<div class="caption">' ;
													echo  '<h3><a href="single-item.php?itemid=' . $ads['item_id'] . '">' . $ads['name'] . '</a></h3>';
													echo  '<p>' . $ads['description'] . '</p>';
													echo  '<span class="date">' . $ads['add_date'] . '</span>';
												echo '</div>';
											echo '</div>' ;
										echo '</div>';
									}
								}else {
									echo 'No ads';
								}
					 		?>
				 		</div>
					</div>
				</div>
			</div>
		</div>

<?php if($count == 0){ header('location:index.php'); }
	include $templateadmin . "footer.php";
ob_end_flush();
?>