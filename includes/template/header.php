<?php ob_start(); ?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8" >
	<title><?php title(); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $cssadmin ?>bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $cssadmin ?>jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $cssadmin ?>all.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $cssadmin ?>jquery.selectBoxIt.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $cssadmin ?>my-front.css">
	</head>
	<body>
	
		<?php if(isset($_SESSION['username'])){
			$statusconut= chackstatus($sess);
			 ?>
			<div class="container sub-profile">
				<img class="img-fluid" src="layout/images/dani.jpg">
				<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
					<?php if($statusconut == 1){
				echo '<button type="button" disabled class="btn btn-secondary">you are not approve yet</button>'; } ?>
					

					<div class="btn-group" role="group">
						<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						menu
						</button>
						<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							<a class="dropdown-item" href="logout.php">logout</a>
							<a class="dropdown-item" href="profile.php">profile</a>
							<a class="dropdown-item" href="newitem.php">new item</a>
						</div>
					</div>
				</div>
			</div>
			
		<?php	
		}else {  ?>

		<div class="up-navbar navbar navbar-light bg-light">
		    <div class="container">
			    <a class="float-right" href="login.php">
			      <span class="">login / sinup</span>
			    </a>
		    </div>
		</div>
		<?php } ?>
<?php ob_end_flush(); ?>