<?php 
ob_start();
	$title = "profile";
	session_start();
	print_r($_SESSION);
	include "init.php";
	if(isset($_SESSION['username'])){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$name 		= FILTER_VAR($_POST['name'], FILTER_SANITIZE_STRING);
			$desc 		= FILTER_VAR($_POST['description'], FILTER_SANITIZE_STRING);
			$price 		= FILTER_VAR($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
			$country 	= FILTER_VAR($_POST['country'], FILTER_SANITIZE_STRING);
			$status 	= FILTER_VAR($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
			$cate 		= FILTER_VAR($_POST['categor'], FILTER_SANITIZE_NUMBER_INT);
			$errors = array();

			if(empty($name)){
				$errors[] = 'feild name can not be empty';
			}
			if(empty($desc)){
				$errors[] = 'feild description can not be empty';
			}
			if(empty($price)){
				$errors[] = 'feild price can not be empty';
			}
			if(empty($country)){
				$errors[] = 'feild country can not be empty';
			}
			if(empty($status)){
				$errors[] = 'feild status can not be empty';
			}
			if(empty($cate)){
				$errors[] = 'feild category can not be empty';
			}
			if(empty($errors)){
						$stmt = $con->prepare("INSERT INTO items(name, description, price, country, status, add_date, cat_id, member_id)
												VALUES (:namekey, :desckey ,:pricekey, :countkey, :statuskey, now(), :cat_idkey, :member_idkey)");
						$stmt->execute(array(
							'namekey' 		=> $name,
							'desckey' 		=> $desc,
							'pricekey'		=> $price,
							'countkey' 		=> $country,
							'statuskey' 	=> $status,
							'cat_idkey'		=> $cate,
							'member_idkey'	=> $_SESSION['use_id']
							
						));
						$count = $stmt->rowcount();
						
						if($count > 0){
							echo '<div class="error-id alert alert-success">Add Success</div>';
							redirectpage('','back');
						}else {echo '<div class="error-id alert alert-danger">Update Error</div>';}
					
				}	

		}?>
	

	<h2 class="h1 text-center">new items</h2>
	<div class="new-items block">
		<div class="container">
			<div class="card">
				<div class="card-header bg-primary">
					item information
				</div>
				<div class="card-body bg-dark">
					<div class="row">
						<div class="col-md-8">
							
							<form class="form-horizontal" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

								<div class="form-group row">
									<label class="col-sm-2 col-form-label">name</label>
									<div class="col-sm-10">
										<input type="text"  name="name" class="form-control live" data-dz=".live-name" autocomplete="nope" placeholder="must be unique">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-2 col-form-label">description</label>
									<div class="col-sm-10">
										<input type="text"  name="description" class="form-control live" data-dz=".live-desc"   placeholder="must be unique">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Price</label>
									<div class="col-sm-10">
										<input type="text"  name="price" class="form-control live"  data-dz=".live-price" placeholder="must be unique">
									</div>
								</div>
								<!--
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">add date</label>
									<div class="col-sm-10">
										<input type="date"  name="date" class="form-control"  placeholder="must be unique">
									</div>
								</div>
							-->
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">country</label>
									<div class="col-sm-10">
										<input type="text"  name="country" class="form-control"  placeholder="must be unique">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">image</label>
									<div class="input-group  col-sm-10">
										<div class="input-group-prepend"><span class="input-group-text">Upload</span></div>
										<div class="custom-file ">
											<input type="file"  name="image" class="custom-file-input"  placeholder="must be unique">
											<label class="custom-file-label">image</label>
										</div>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-2 col-form-label">status</label>
									<div class="col-sm-10">
										<select name="status">
											<option value="0">!!!!</option>
											<option value="1">new</option>
											<option value="2">like new</option>
											<option value="3">good</option>
											<option value="4">old</option>
											<option value="5">very old</option>
										</select>
									</div>
								</div>

								
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">categories</label>
									<div class="col-sm-10">
										<select name="categor">
											<option value="0">!!!!</option> <?php
											$stmt_e = $con->prepare('SELECT * FROM categories');
											$stmt_e->execute();
											$cate = $stmt_e->fetchall();
											foreach($cate as $cat){
												echo '<option value="' . $cat["cat_id"] . '">' . $cat["name"] . '</option>';}?>			
										</select>
									</div>
								</div>
								
								<div class="form-group row">
									<div class="offset-sm-2 col-sm-10">
										<input type="submit" value="Add" class="btn btn-primary btn-block">
									</div>
								</div>
							</form>

						</div>
						<div class="col-md-4">
							<div class="img-thumbnail box-item">
								<span class="price">Dz <span class="live-price">???</span></span>
								<img  class="img-fluid" src="layout/images/dani.jpg">
								<div class="caption">
									<h2 class="live-name">Name</h2>
									<p class="live-desc">Description</p>
								</div>
							</div>
						</div>
						<?php
						if(!empty($errors)){
							foreach($errors as $error){
								echo '<div class="alert alert-danger alert-dismissible fade show btn-block">' . $error . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									    <span aria-hidden="true">&times;</span>
									  </button></div>';
							}
						} ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	

<?php }else{
	header('location:index.php');
}	include $templateadmin . "footer.php";
ob_end_flush();
?>