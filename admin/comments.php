<?php


session_start();
$title = "comments";

if(isset($_SESSION['user'])){ // request exist
	include 'init.php';

		$do =isset($_GET['daniels']) ? $_GET['daniels'] : 'manage';
/*    */if ($do == 'manage'){ 
			
			$stmt=$con->prepare("SELECT comment.*, items.name, users.username FROM comment INNER JOIN items ON items.item_id = comment.item_id INNER JOIN users ON users.user_id = comment.user_id");
			$stmt->execute();
			$test = $stmt->fetchAll();

	?>
			<h2 class="h1 text-center">manage comment</h2>
			<div class="container">
				<div class="table-responsive  ">
					<table class="text-center main-table table table-bordered table-dark table-striped">
						<tr>
							<td>comment</td>
							<td>status</td>
							<td>DATE</td>
							<td>item</td>
							<td>user</td>
							<td>Contole</td>
						</tr>
				<?php   foreach($test as $tes){

							echo '<tr>' ;
								echo '<td>' . $tes['comment'] . '</td>';
								echo '<td>' . $tes['co_status'] .' </td>';
								echo '<td>' . $tes['add_date'] . '</td>';
								echo '<td>' . $tes['name'] . '</td>';
								echo '<td>' . $tes['username'] . '</td>';
								echo '<td>
									<a href="?daniels=edit&coid=' . $tes['co_id'] . '" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
									<a href="?daniels=delete&coid=' . $tes['co_id'] . '" class="btn btn-danger confirm"><i class="fas fa-times"></i> delete</a>';
									if($tes['co_status'] == 0){
							echo   '<a href="?daniels=approve&coid=' .  $tes['co_id'] . '" class="btn btn-info btn-act"><i class="fas fa-question"></i> Active</a>';
									}else {
										echo '<a href="#" class="disabled btn btn-info btn-act"><i class="fas fa-check"></i> DEAct</a>';
									}

							echo	  '</td>';
							echo '</tr>';
				} ?>
					</table>
					
				</div>
			</div>


			<?php
/*    */}elseif($do == 'edit'){ 
			$coid = isset($_GET["coid"]) && is_numeric($_GET["coid"]) ? intval($_GET["coid"]) : 0 ;
			$stmt=$con->prepare('SELECT * FROM comment WHERE co_id = ? ');
			$stmt->execute(array($coid));
			$fetch = $stmt->fetch();
			$count = $stmt->rowcount();
			
			if($count > 0){ ?>	

			<div class="container">
				<form class="form-horizontal" action="?daniels=update" method="post">
					<h2 class="h1 text-center">Edit comment</h2>
					<input type="hidden" name="id" value="<?php echo $coid; ?>">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">comment</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="comment"><?php echo $fetch['comment']; ?></textarea>
						</div>
					</div>
					
					<div class="form-group row">
						<div class="offset-sm-2 col-sm-10">
							<input type="submit" value="SIVE" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>

			</div>



			<?php 

			}else {echo '<div class="error-id">what you wanna do</div>' ;} 

/*    */}elseif($do == 'update'){  // if update 
			
			
			echo '<h2 class="h1 text-center">Update User</h2>';
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				$co_id 	= $_POST['id'];
				$comm 	= $_POST['comment'];

				$error = array();
				if (strlen($comm) < 6 ) {$error[] = 'your comment must be more then 6 char';}
				if (empty($comm)) {$error[] = 'your comment must be more then 6 char';}
				if(!empty($error)){
					foreach ($error as $err ) {echo '<div class="alert alert-danger">' . $err . '</div>';} 
				}else {

					$stmt = $con->prepare('UPDATE comment SET comment = ? WHERE co_id = ? '); 
					$stmt->execute(array($comm,$co_id));
					$count = $stmt->rowcount();
					if($count > 0){
						echo '<div class="error-id alert alert-success">Update Success</div>';
						redirectpage('','back');
					}//else {echo '<div class="error-id alert alert-danger">Update Error</div>';}
					
				}
			}else{
				$error = 'you can not browse this page direct </br>';
				echo ' <div class="erro-tow container text-center"><div class="alert alert-dark">';
				redirectpage($error);
				echo '</div></div>';
			}

/*    */}elseif($do == 'delete' ){
		echo '<h2 class="h1 text-center">DELETE comment</h2>';
		echo '<div class="container">';

		$coid = isset($_GET['coid']) && is_numeric($_GET['coid']) ? intval($_GET['coid']) : 0;
		
		$check = chackusername('co_id','comment',$coid);
		if($check > 0){
			$stmt = $con->prepare('DELETE FROM comment WHERE co_id = :zid');
			$stmt->bindparam(':zid', $coid);
			$stmt->execute();
			$count = $stmt->rowcount();
			if($count > 0){
				$error = '<div class="error-id alert alert-success">delete Success</div>';
				redirectpage($error,'back');
			}else{ $error = '<div class="error-id alert alert-danger">delete Error</div>';
					redirectpage($error,'back'); }
		}else{
			$error = 'you can not browse this page direct </br>';
				echo ' <div class="erro-tow container text-center"><div class="alert alert-dark">';
				redirectpage($error);
				echo '</div></div>';
		}
		echo '</div>';


/*    */}elseif($_GET['daniels'] == 'approve'){
			echo '<h2 class="h1 text-center">delete User</h2>';
			echo '<div class="container">';

				$coid = isset($_GET['coid']) && is_numeric($_GET['coid']) ? intval($_GET['coid']) : 0;
				
				$check = chackusername('co_id','comment',$coid);
				if($check > 0){
					echo 'ok';
					$stmt = $con->prepare('UPDATE comment SET co_status = 1 WHERE co_id = ?');
					
					$stmt->execute(array($coid));
					$count = $stmt->rowcount();
					if($count > 0){
						$error = '<div class="error-id alert alert-success">activate Success</div>';
						redirectpage($error,'back');
					}else{ $error = '<div class="error-id alert alert-danger">activate Error</div>';
							redirectpage($error,'back'); }
				}else{
					$error = 'you can not browse this page direct </br>';
						echo ' <div class="erro-tow container text-center"><div class="alert alert-dark">';
						redirectpage($error);
						echo '</div></div>';
				}
			echo '</div>';

/*    */}else{echo 'error';}	// else update

	include $templateadmin . "footer.php";
}else {  // request not exist
		header('location:index.php');
		exit();
}