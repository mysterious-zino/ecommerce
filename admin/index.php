<?php 
ob_start();
	$nonav = '';
	$title = "login";
	session_start();
	if(isset($_SESSION['user'])){
		header('location:dashbourd.php');
	}
	include "init.php";
	
	if($_SERVER['REQUEST_METHOD'] == 'POST' ){
		$username = $_POST['user'];
		$password = $_POST['pass'];
		$shapass	= sha1($password);
		$stmt = $con->prepare('SELECT user_id , username , password from users where username = ? and password = ? AND groob_id = 1 limit 1');
		$stmt->execute(array($username , $shapass));
		$fetch =($stmt->fetch());
		$count = $stmt->rowcount();
		if($count > 0){
			echo 'Welcom to uor comunity';
			$_SESSION['user']=$username;
			$_SESSION['user_id']=$fetch['user_id'];
			header('location:dashbourd.php');
			exit();
		}else {
			echo 'you can registr any time , feel free to injoy with as';
		}
	}
?>
	<form class="login" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
		<h2 class="h1 text-center">Welcome</h2>
		<input class="form-control"type="text" name="user" autocomplete="off" placeholder="username">
		<input class="form-control"type="password" name="pass" autocomplete="new-password" placeholder="password">
		<input class="btn btn-primary btn-block"type="submit" value="login">
	</form>
<?php
	include $templateadmin . "footer.php";
ob_end_flush();
?>