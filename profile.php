<?php 
ob_start();
	$title = "profile";
	session_start();

	include "init.php";
	if(isset($_SESSION['username'])){

		$stmt_g = $con->prepare("SELECT * FROM users WHERE username = ?");
		$stmt_g->execute(array($sess));
		$info =$stmt_g->fetch();
		echo $info['username'];
		$name = $_SESSION['username'];
		$id = $_SESSION['use_id'];

		if(isset($_GET['name']) && isset($_GET['id'])){
			$n = $_GET['name'];
			$i = $_GET['id'];
			$stmt = $con->prepare("SELECT * FROM users WHERE username = ? AND user_id = ?");
			$stmt->execute(array($n, $i));
			$fetsh =$stmt->fetch();
			echo '<pre>';
			print_r($fetsh);
			echo '</pre>';
		}

	 ?>
	

	<h2 class="h1 text-center"><?php echo $sess ?></h2>
	<div class="information block">
		<div class="container">
			<div class="card">
				<div class="card-header bg-primary">
					my information
				</div>
				<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
					<button type="button" class="btn btn-secondary">1</button>
					<button type="button" class="btn btn-secondary">2</button>

					<div class="btn-group" role="group">
						<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Dropdown
						</button>
						<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							<a class="dropdown-item" href="#">Dropdown link</a>
							<a class="dropdown-item" href="#">Dropdown link</a>
						</div>
					</div>
				</div>
				<div class="card-body bg-dark">
					<ul class="list-unstyled">
					<li><i class="fas fa-unlock-alt fa-fw"></i>
						<span>NAME</span> : <?php echo $info['username']; ?></li>
					<li><i class="fas fa-envelope fa-fw"></i>
						<span>FullName</span> : <?php echo $info['fullname']; ?></li>
					<li><i class="fas fa-user fa-fw"></i>
						<span>Email</span>	: <?php echo $info['email']; ?></li>
					<li><i class="fas fa-calendar fa-fw"></i>
						<span>Register Date</span> : <?php echo $info['date']; ?></li>
					<li><i class="fas fa-tag fa-fw"></i>
						<span>Favourite Ctegories</span>: <?php echo $info['username']; ?></li>
					</ul>
					<a href="profile.php?name=<?php echo $name ?>&id=<?php echo $id; ?>" class="btn btn-secondary">Edit Enformation</a>
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
	</div>

	<div class="latest-comment block">
		<div class="container">
			<div class="card">
				<div class="card-header bg-danger">
					my latest comment
				</div>
				<div class="card-body bg-light">
					<?php 
						$stmt=$con->prepare("SELECT comment.*,items.name FROM comment INNER JOIN items ON items.item_id = comment.item_id WHERE user_id = ?");
						$stmt->execute(array($info['user_id']));
						$comments = $stmt->fetchAll();
						if(!empty($comments)){
							foreach($comments as $comment){
								echo '<div class="comment-box">';
								echo '<a href="items.php?daniels=edit&userid=' . $comment['item_id'] . '"><span class="member-n">' . $comment['name'] . '</span></a>';
								echo '<p class="member-c">' . $comment['comment'] . '</p>';
								echo '</div>';
								echo '<a href="comments.php?daniels=edit&coid=' . $comment['co_id'] . '" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
									<a href="comments.php?daniels=delete&coid=' . $comment['co_id'] . '" class="btn btn-danger confirm"><i class="fas fa-times"></i> delete</a>';
									if($comment['co_status'] == 0){
							echo   '<a href="comments.php?daniels=approve&coid=' .  $comment['co_id'] . '" class="btn btn-info btn-act"><i class="fas fa-question"></i> Active</a>';
									}else { echo '<a href="#" class="disabled btn btn-info btn-act"><i class="fas fa-check"></i> DEAct</a>'; }
							}
						}else {
							echo 'No Comment';
						}
					?>
				</div>
			</div>
		</div>
	</div>
	

<?php }else{
	header('location:index.php');
}	include $templateadmin . "footer.php";
ob_end_flush();
?>