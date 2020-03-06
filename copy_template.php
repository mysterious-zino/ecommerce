<?php

ob_start();
session_start();
$title = "categories";

if(isset($_SESSION['user'])){ // request exist
	include 'init.php';

		$do =isset($_GET['daniels']) ? $_GET['daniels'] : 'manage';

/*    */if ($do == 'manage'){ 
		
/*    */}elseif($do == 'add'){ 

/*    */}elseif($do == 'insert'){
			
/*    */}elseif($do == 'edit'){ 
			
/*    */}elseif($do == 'update'){  // if update 
		
/*    */}elseif($do == 'delete' ){
		
/*    */}elseif($_GET['daniels'] == 'activate'){
			
/*    */}else{echo 'error';}	// else update

	include $templateadmin . "footer.php";
}else {  // request not exist
		header('location:index.php');
		exit();
}
ob_end_flush();