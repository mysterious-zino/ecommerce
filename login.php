<?php 
ob_start();
	$title = "main";
	session_start();
	if(isset($_SESSION['username'])){
		header('location:index.php');
	}include "init.php"; 
	if($_SERVER['REQUEST_METHOD'] == 'POST' ){
		if(isset($_POST['login'])){
			$username = $_POST['user'];
			$password = $_POST['password'];
			$shapass	= sha1($password);
			$stmt = $con->prepare('SELECT user_id , username , password from users where username = ? and password = ? ');
			$stmt->execute(array($username , $shapass));
			$fetch = $stmt->fetch();
			$count = $stmt->rowcount();
			if($count > 0){
				echo 'Welcom to uor comunity';
				$_SESSION['username']=$username;
				$_SESSION['use_id']=$fetch['user_id'];
				header('location:index.php');
				exit();
			}else {
				echo 'you can registr any time , feel free to injoy with as';
			}
		}else {
			$errorform = array();
			$username = $_POST['name'];
			$pass1 = $_POST['password'];
			$pass2 = $_POST['password2'];
			$email = $_POST['email'];
			if(isset($username)){
				$namesignup = FILTER_VAR($username, FILTER_SANITIZE_STRING);
				if(strlen($namesignup) < 4){
				$errorform[] = 'your name must be more then 5 char';
				} 
			}
			if(isset($pass1) && isset($pass2)){
				if(strlen($pass1) < 4){
				$errorform[] = 'your password very week';
				}
				$pas1 = sha1($_POST['password']);
				$pas2 = sha1($_POST['password2']);
				if($pas1 !== $pas2){
				$errorform[] = 'your password not match';
				}
			}
			if(isset($email)){
				$emai = FILTER_VAR($email,FILTER_SANITIZE_EMAIL);
				if(FILTER_VAR($emai, FILTER_VALIDATE_EMAIL) != true){
				$errorform[] = 'your email not correct'; 
				}
			}

			if(empty($errorform)){
					$chec = chackusername('name','items',$username);
					if($chec == 1){
						$errorform[] = 'sorry this username is exist</br>';
					}else{
						$stmt_d = $con->prepare("INSERT INTO users(username, password, email, reg_status, date)
												VALUES (:userkey, :passkey ,:emailkey, 0, now())");
						$stmt_d->execute(array(
							'userkey' => $username,
							'passkey' => sha1($pass),
							'emailkey'=> $email
						));
						$count = $stmt_d->rowcount();
						
						if($count > 0){
							echo '<div class="error-id alert alert-success">Add Success</div>';
							/*header('location:index.php');*/
						}else {echo '<div class="error-id alert alert-danger">Update Error</div>';}
					}
				}else {
					
				}


		}
	}

	?>
	<div class="login-box">
		<div class="container">
			<div class="back">
				<h2 class="text-center"><span class="active" data-banona="login">LOGIN</span> | <span data-banona="signup">SIGNUP</span></h2>
				<form class="login" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
					<div class="login-group row"><input type="text" class ="form-control" placeholder="Username" required="" name="user" autocomplete="nope"></div>
					<div class="login-group row"><input type="password" class ="form-control" placeholder="password" name="password" autocomplete="new-password"></div>
					<div class="login-group row"><input type="submit" name="login" class ="form-control btn-info" value="login"></div>
						
						
						
					
				</form>

				<form class="signup" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
					<div class="">
						<div class="login-group row"><input type="text" class ="form-control" placeholder="Username" name="name" autocomplete="nope"></div>
						<div class="login-group row"><input type="password" class ="form-control" placeholder="password" name="password" autocomplete="new-password"></div>
						<div class="login-group row"><input type="password" class ="form-control" placeholder="confirm password" name="password2" autocomplete="new-password"></div>
						<div class="login-group row"><input type="text" class ="form-control" placeholder="email" name="email" autocomplete="nope"></div>
						<div class="login-group row"><input type="submit" name="signup" class ="form-control btn-success" value="signup"></div>
					</div>
				</form>
				<div class="error text-center">
					<?php 
					if(!empty($errorform)){
						echo '<ul>';
						foreach($errorform as $errors){
							echo '<li>' . $errors . '</li>';
						}
						echo '</ul>';
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
	include $templateadmin . "footer.php";
ob_end_flush();
?>