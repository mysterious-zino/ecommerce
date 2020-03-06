<?php


session_start();
$title = "members";

if(isset($_SESSION['user'])){ // request exist
	include 'init.php';

		$do =isset($_GET['daniels']) ? $_GET['daniels'] : 'manage';
/*    */if ($do == 'manage'){ 
			$activ = '';
			if(isset($_GET['activ']) && $_GET['activ'] == 'active'){
				$activ = 'AND reg_status = 1';
			}elseif(isset($_GET['deactiv']) && $_GET['deactiv'] == 'panding'){
				$activ =' AND reg_status = 0';
				$tesmant = 1;
			}
			$stmt=$con->prepare("SELECT * FROM users WHERE groob_id != 1 $activ");
			$stmt->execute();
			$test = $stmt->fetchAll();

	?>
			<h2 class="h1 text-center">ADD User Form</h2>
			<div class="container">
				<div class="table-responsive  ">
					<table class="text-center main-table table table-bordered table-dark table-striped">
						<tr>
							<td>Username</td>
							<td>UserID</td>
							<td>Email</td>
							<td>Fullname</td>
							<td>DATE</td>
							<td>Date Register</td>
							<td>Contole</td>
						</tr>
				<?php   foreach($test as $tes){

							echo '<tr>' ;
								echo '<td>' . $tes['username'] . '</td>';
								echo '<td>' . $tes['user_id'] .' </td>';
								echo '<td>' . $tes['email'] . '</td>';
								echo '<td>' . $tes['fullname'] . '</td>';
								echo '<td>' . $tes['date'] . '</td>';
								echo '<td>data register</td>';
								echo '<td>
									<a href="?daniels=edit&userid=' . $tes['user_id'] . '" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
									<a href="?daniels=delete&userid=' . $tes['user_id'] . '" class="btn btn-danger confirm"><i class="fas fa-times"></i> delete</a>';
									if($tes['reg_status'] == 0){
							echo   '<a href="?daniels=activate&userid=' .  $tes['user_id'] . '" class="btn btn-info btn-act"><i class="fas fa-question"></i> Active</a>';
									}else {
										echo '<a href="#" class="disabled btn btn-info btn-act"><i class="fas fa-check"></i> DEAct</a>';
									}

							echo	  '</td>';
							echo '</tr>';
				} ?>
					</table>
					<a href="?daniels=add"><div class="btn btn-primary"><i class="fas fa-plus"></i>
					 &nbsp; add membars</div></a>
					 <a href="?daniels=manage&activ=active"><div class="btn btn-primary"><i class="fas fa-plus"></i>
					 &nbsp; active membars</div></a>
					 <a href="?daniels=manage&deactiv=panding"><div class="btn btn-primary"><i class="fas fa-plus"></i>
					 &nbsp; unactive membars</div></a>
					 <a href="?daniels=manage"><div class="btn btn-primary"><i class="fas fa-plus"></i>
					 &nbsp; All membars</div></a>
				</div>
			</div>


			<?php
/*    */}elseif($do == 'add'){ ?>

			<div class="container">
				<form class="form-horizontal" action="?daniels=insert" method="post">
					<h2 class="h1 text-center">ADD User Form</h2>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Username</label>
						<div class="col-sm-10">
							<input type="text" required='required' name="username" class="form-control" autocomplete="nope" placeholder="must be unique">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Password</label>
						<div class="col-sm-10">
							<input type="password" name="password" class="password form-control"autocomplete="new-password" required="required" placeholder="must be hard and complex">
							<i class="show-pass fas fa-eye-slash"></i>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Email</label>
						<div class="col-sm-10">
							<input class="form-control" type="email" required='required' name="email" placeholder="email must be rial" >
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Fullname</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" required='required' name="full" placeholder="must be true" >
						</div>
					</div>
					<div class="form-group row">
						<div class="offset-sm-2 col-sm-10">
							<input type="submit" value="Add" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>

			</div>

		<?php

		}elseif($do == 'insert'){
			echo '<h2 class="h1 text-center">this is insert page</h2>';
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$user 	= $_POST['username'];
				$pass 	= $_POST['password'];
				$email 	= $_POST['email'];
				$full 	= $_POST['full'];
				$passdb = sha1($_POST['password']);
				
				$error = array();
				if (strlen($user)< 6 ) {$error[] = 'your username must be more then 6 char';}
				if (empty($email)) {$error[] = 'your email must be more then 6 char';}
				if (strlen($full) < 6) {$error[] = 'your fullname must be more then 6 char';}

				if(!empty($error)){
					foreach ($error as $err ) {echo '<div class="alert alert-danger">' . $err . '</div>';} 
				}else {
					$check = chackusername('username','users','$user');
					if($check == 1){
						$error= 'sorry this username is exist</br>';
						echo ' <div class="erro-tow container text-center"><div class="alert alert-dark">';
						redirectpage($error,'back');
						echo '</div></div>';
					}else{
						$stmt = $con->prepare("INSERT INTO users(username, password, email, fullname, reg_status, date)
																		VALUES (:userkey, :passkey ,:emailkey, :fullkey, 1, now())");
						$stmt->execute(array(
							'userkey' => $user,
							'passkey' => $passdb,
							'emailkey'=> $email,
							'fullkey' => $full
						));
						$count = $stmt->rowcount();
						
						if($count > 0){
							echo '<div class="error-id alert alert-success">Add Success</div>';
							redirectpage('','back');
						}else {echo '<div class="error-id alert alert-danger">Update Error</div>';}
					}
				}	
			}else{
				$error = 'you can not browse this page direct </br>';
				echo ' <div class="erro-tow container text-center"><div class="alert alert-dark">';
				redirectpage($error);
				echo '</div></div>';
			}


/*    */}elseif($do == 'edit'){ 
			$userid = isset($_GET["userid"]) && is_numeric($_GET["userid"]) ? intval($_GET["userid"]) : 0 ;
			$stmt=$con->prepare('SELECT* FROM users WHERE user_id = ? LIMIT 1');
			$stmt->execute(array($userid));
			$fetch = $stmt->fetch();
			$count = $stmt->rowcount();
			
			if($count > 0){ ?>	

			<div class="container">
				<form class="form-horizontal" action="?daniels=update" method="post">
					<h2 class="h1 text-center">Edit Profile</h2>
					<input type="hidden" name="id" value="<?php echo $userid; ?>">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Username</label>
						<div class="col-sm-10">
							<input type="text" required='required' name="username" class="form-control" autocomplete="nope" value="<?php echo $fetch['username'] ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Password</label>
						<div class="col-sm-10">
							<input type="hidden" name="oldpassword" value="<?php echo $fetch["password"]; ?>">
							<input type="password" value="<?php  ?>" name="newpassword" class="form-control"autocomplete="new-password" placeholder="leave blank if you dont want to change">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Email</label>
						<div class="col-sm-10">
							<input type="email" required='required' name="email" value="<?php echo $fetch['email'] ?>" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Fullname</label>
						<div class="col-sm-10">
							<input type="text" required='required' name="full"value="<?php echo $fetch['fullname'] ?>" class="form-control">
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
				$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);
				$name 	= $_POST['username'];
				$email 	= $_POST['email'];
				$full 	= $_POST['full'];
				$id 	= $_POST['id'];
				$error = array();
				if (strlen($name)< 6 ) {$error[] = 'your username must be more then 6 char';}
				if (empty($email)) {$error[] = 'your email must be more then 6 char';}
				if (strlen($full) < 6) {$error[] = 'your fullname must be more then 6 char';}
				if(!empty($error)){
					foreach ($error as $err ) {echo '<div class="alert alert-danger">' . $err . '</div>';} 
				}else {
					$check = chackusername('username','users',$name);
					if($check == 1){
						$error= 'sorry this username is exist</br>';
						echo ' <div class="erro-tow container text-center"><div class="alert alert-dark">';
						redirectpage($error,'back');
						echo '</div></div>';
						
					}else {
					$stmt = $con->prepare('UPDATE users SET username = ?, email = ?, fullname = ?, password = ? WHERE user_id = ? '); 
					$stmt->execute(array($name, $email, $full, $pass, $id));
					$count = $stmt->rowcount();
					if($count > 0){
						echo '<div class="error-id alert alert-success">Update Success</div>';
						redirectpage('','back');
					}//else {echo '<div class="error-id alert alert-danger">Update Error</div>';}
					}
				}
			}else{
				$error = 'you can not browse this page direct </br>';
				echo ' <div class="erro-tow container text-center"><div class="alert alert-dark">';
				redirectpage($error);
				echo '</div></div>';
			}

/*    */}elseif($do == 'delete' ){
		echo '<h2 class="h1 text-center">DELETE User</h2>';
		echo '<div class="container">';

		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
		
		$check = chackusername('user_id','users',$userid);
		if($check > 0){
			$stmt = $con->prepare('DELETE FROM users WHERE user_id = :zid');
			$stmt->bindparam(':zid', $userid);
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


/*    */}elseif($_GET['daniels'] == 'activate'){
			echo '<h2 class="h1 text-center">delete User</h2>';
			echo '<div class="container">';

				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
				
				$check = chackusername('user_id','users',$userid);
				if($check > 0){
					echo 'ok';
					$stmt = $con->prepare('UPDATE users SET reg_status = 1 WHERE user_id = ?');
					
					$stmt->execute(array($userid));
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