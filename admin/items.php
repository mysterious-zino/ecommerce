<?php

ob_start();
session_start();
$title = "items";

if(isset($_SESSION['user'])){ // request exist
	include 'init.php';

		$do =isset($_GET['daniels']) ? $_GET['daniels'] : 'manage';

/*    */if ($do == 'manage'){ 
			$stmt=$con->prepare("SELECT items.*,categories.name as cat_name,users.username  FROM items INNER JOIN categories ON categories.cat_id = items.cat_id INNER JOIN users ON users.user_id = items.member_id");
			$stmt->execute();
			$fetchal = $stmt->fetchAll();

	?>
			<h2 class="h1 text-center">Items Control</h2>
			<div class="container">
				<div class="table-responsive  ">
					<table class="text-center main-table table table-bordered table-dark table-striped">
						<tr>
							<td>ID</td>
							<td>name</td>
							<td>description</td>
							<td>price</td>
							<td>add date</td>
							<td>country</td>
							<td>status</td>
							<td>rating</td>
							<td>member_id</td>
							<td>cat_id</td>
							<td>Contole</td>
						</tr>
				<?php   foreach($fetchal as $fetcha){

							echo '<tr>' ;
								echo '<td>' . $fetcha['item_id'] . '</td>';
								echo '<td>' . $fetcha['name'] . '</td>';
								echo '<td>' . $fetcha['description'] .' </td>';
								echo '<td>' . $fetcha['price'] . '</td>';
								echo '<td>' . $fetcha['add_date'] . '</td>';
								echo '<td>' . $fetcha['country'] . '</td>';
								echo '<td>' . $fetcha['status'] . '</td>';
								echo '<td>' . $fetcha['rating'] . '</td>';
								echo '<td>' . $fetcha['username'] . '</td>';
								echo '<td>' . $fetcha['cat_name'] . '</td>';
								
								echo '<td>
									<a href="?daniels=edit&itemid=' . $fetcha['item_id'] . '" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
									<a href="?daniels=delete&itemid=' . $fetcha['item_id'] . '" class="btn btn-danger confirm"><i class="fas fa-times"></i> delete</a>';
									if($fetcha['approve'] == 0){
							echo   '<a href="?daniels=approved&itemid=' .  $fetcha['item_id'] . '" class="btn btn-info btn-act"><i class="fas fa-question"></i> Approve</a>';
									}else {
										echo '<a href="#" class="disabled btn btn-info btn-act"><i class="fas fa-check"></i> DEAct</a>';
									}

							echo	  '</td>';
							echo '</tr>';
				} ?>
					</table>
					<a href="?daniels=add"><div class="btn btn-primary"><i class="fas fa-plus"></i>
					 &nbsp; add Items</div></a><!--
					 <a href="?daniels=manage&activ=active"><div class="btn btn-primary"><i class="fas fa-plus"></i>
					 &nbsp; active membars</div></a>
					 <a href="?daniels=manage&deactiv=panding"><div class="btn btn-primary"><i class="fas fa-plus"></i>
					 &nbsp; unactive membars</div></a>
					 <a href="?daniels=manage"><div class="btn btn-primary"><i class="fas fa-plus"></i>
					 &nbsp; All membars</div></a> -->
				</div>
			</div>


		<?php
/*    */}elseif($do == 'add'){ ?>

			<div class="container">
				<form class="form-horizontal" action="?daniels=insert" method="post">
					<h2 class="h1 text-center">ADD items Form</h2>

					<div class="form-group row">
						<label class="col-sm-2 col-form-label">name</label>
						<div class="col-sm-10">
							<input type="text" required='required' name="name" class="form-control" autocomplete="nope" placeholder="must be unique">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2 col-form-label">description</label>
						<div class="col-sm-10">
							<input type="text"  name="description" class="form-control"  placeholder="must be unique">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Price</label>
						<div class="col-sm-10">
							<input type="text"  name="price" class="form-control"  placeholder="must be unique">
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
						<label class="col-sm-2 col-form-label">users</label>
						<div class="col-sm-10">
							<select name="users">
								<option value="0">!!!!</option> <?php
								$stmt = $con->prepare('SELECT * FROM users');
								$stmt->execute();
								$users = $stmt->fetchall();
								foreach($users as $user){
									echo '<option value="' . $user["user_id"] . '">' . $user["username"] . '</option>';}?>			
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

		<?php
			
/*    */}elseif($do == 'insert'){
			echo '<h2 class="h1 text-center">this is insert item page</h2>';
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$name 	= $_POST['name'];
				$desc	= $_POST['description'];
				$price 	= $_POST['price'];
				$count 	= $_POST['country'];
				$status = $_POST['status'];
				$imag 	= $_POST['image'];
				$admin 	= $_POST['users'];
				$catego = $_POST['categor'];
				
				$error = array();
				if (strlen($desc) < 6 ) {$error[] = 'your description must be more then 6 char';}
				if (empty($name)) {$error[] = 'name field can not be empty';}
				if (empty($desc)) {$error[] = 'description field can not be empty';}
				if (empty($price)) {$error[] = 'price field can not be empty';}
				if ($status == 0) {$error[] = 'status field can not be empty';}
				if (empty($count)) {$error[] = 'country field can not be empty';}

				if(!empty($error)){
					foreach ($error as $err ) {echo '<div class="alert alert-danger">' . $err . '</div>';} 
				}else {
					
					
						$stmt = $con->prepare("INSERT INTO items(name, description, price, country, status, add_date, cat_id, member_id)
												VALUES (:namekey, :desckey ,:pricekey, :countkey, :statuskey, now(), :cat_idkey, :member_idkey)");
						$stmt->execute(array(
							'namekey' 		=> $name,
							'desckey' 		=> $desc,
							'pricekey'		=> $price,
							'countkey' 		=> $count,
							'statuskey' 	=> $status,
							'cat_idkey'		=> $catego,
							'member_idkey'	=> $admin
							
						));
						$count = $stmt->rowcount();
						
						if($count > 0){
							echo '<div class="error-id alert alert-success">Add Success</div>';
							redirectpage('','back');
						}else {echo '<div class="error-id alert alert-danger">Update Error</div>';}
					
				}	
			}else{
				$error = 'you can not browse this page direct </br>';
				echo ' <div class="erro-tow container text-center"><div class="alert alert-dark">';
				redirectpage($error);
				echo '</div></div>';
			}
			
/*    */}elseif($do == 'edit'){ 
			$itemid = isset($_GET["itemid"]) && is_numeric($_GET["itemid"]) ? intval($_GET["itemid"]) : 0 ;
			$stmt=$con->prepare('SELECT* FROM items WHERE item_id = ?');
			$stmt->execute(array($itemid));
			$fetch = $stmt->fetch();
			$count = $stmt->rowcount();
			
			if($count > 0){ ?>	
				<div class="container">
					<form class="form-horizontal" action="?daniels=update" method="post">
						<h2 class="h1 text-center">edit items Form</h2>
						<input type="hidden" name="item-id" value="<?php echo $itemid; ?>">
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">name</label>
							<div class="col-sm-10">
								<input type="text" required='required' name="name" value="<?php echo $fetch["name"]; ?>" class="form-control" autocomplete="nope" placeholder="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 col-form-label">description</label>
							<div class="col-sm-10">
								<input type="text"  name="description" value="<?php echo $fetch["description"]; ?>" class="form-control"  placeholder="must be unique">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Price</label>
							<div class="col-sm-10">
								<input type="text"  name="price" value="<?php echo $fetch["price"]; ?>" class="form-control"  placeholder="must be unique">
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
								<input type="text"  name="country" value="<?php echo $fetch["country"]; ?>" class="form-control"  placeholder="must be unique">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">image</label>
							<div class="input-group  col-sm-10">
								<div class="input-group-prepend"><span class="input-group-text">Upload</span></div>
								<div class="custom-file ">
									<input type="file"  name="image"  class="custom-file-input"  placeholder="must be unique">
									<label class="custom-file-label">image</label>
								</div>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 col-form-label">status</label>
							<div class="col-sm-10">
								<select name="status">
									<option value="1" <?php if($fetch["status"] == 1){echo 'selected';} ?> >new</option>
									<option value="2" <?php if($fetch["status"] == 2){echo 'selected';} ?> >like new</option>
									<option value="3" <?php if($fetch["status"] == 3){echo 'selected';} ?> >good</option>
									<option value="4" <?php if($fetch["status"] == 4){echo 'selected';} ?> >old</option>
									<option value="5" <?php if($fetch["status"] == 5){echo 'selected';} ?> >very old</option>
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 col-form-label">users</label>
							<div class="col-sm-10">
								<select name="users"> <?php
									$stmt = $con->prepare('SELECT * FROM users');
									$stmt->execute();
									$users = $stmt->fetchall();
									foreach($users as $user){
										echo '<option value="' . $user["user_id"] . '" ';if($fetch["member_id"] == $user["user_id"]){echo 'selected';} echo ' >' .  $user["username"] . '</option>';}?>			
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">categories</label>
							<div class="col-sm-10">
								<select name="categor"> <?php
									$stmt_e = $con->prepare('SELECT * FROM categories');
									$stmt_e->execute();
									$cate = $stmt_e->fetchall();
									foreach($cate as $cat){
										echo '<option value="' . $cat["cat_id"] . '" ' ;if($fetch["cat_id"] == $cat["cat_id"]){echo 'selected';} echo '>' . $cat["name"] . '</option>';}?>			
								</select>
							</div>
						</div>
						
						<div class="form-group row">
							<div class="offset-sm-2 col-sm-10">
								<input type="submit" value="Add" class="btn btn-primary btn-block">
							</div>
						</div>
					</form>

						<?php 

						$stmt=$con->prepare("SELECT comment.*,users.username FROM comment INNER JOIN users ON users.user_id = comment.user_id WHERE item_id = ?");
						$stmt->execute(array($itemid));
						$test = $stmt->fetchAll();
						if(!empty($test)){
				?>
						<h2 class="h1 text-center">manage [<?php echo $fetch['name'];?>] comment</h2>
							<div class="table-responsive  ">
								<table class="text-center main-table table table-bordered table-dark table-striped">
									<tr>
										<td>comment</td>
										
										<td>DATE</td>
										
										<td>user</td>
										<td>Contole</td>
									</tr>
							<?php   foreach($test as $tes){

										echo '<tr>' ;
											echo '<td>' . $tes['comment'] . '</td>';
											
											echo '<td>' . $tes['add_date'] . '</td>';
											
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
					
				<?php	} ?>
				</div>
			<?php 

			}else {echo '<div class="error-id">what you wanna do</div>' ;}
/*    */}elseif($do == 'update'){  // if update 
			echo '<h2 class="h1 text-center">Update items</h2>';
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$item_d = $_POST['item-id'];
				$name 	= $_POST['name'];
				$desc	= $_POST['description'];
				$price 	= $_POST['price'];
				$count 	= $_POST['country'];
				$status = $_POST['status'];
				$imag 	= $_POST['image'];
				$admin 	= $_POST['users'];
				$catego = $_POST['categor'];
				
				$error = array();
				if (strlen($desc) < 6 ) {$error[] = 'your description must be more then 6 char';}
				if (empty($name)) {$error[] = 'name field can not be empty';}
				if (empty($desc)) {$error[] = 'description field can not be empty';}
				if (empty($price)) {$error[] = 'price field can not be empty';}
				if ($status == 0) {$error[] = 'status field can not be empty';}
				if (empty($count)) {$error[] = 'country field can not be empty';}

				if(!empty($error)){
					foreach ($error as $err ) {echo '<div class="alert alert-danger">' . $err . '</div>';} 
				}else {
					$check = chackusername('name','items',$name);
					if ($check == 1){
						$checkid = chackupdate('name','item_id','items',$name,$item_d);
						if($checkid == 1){
							echo 'this name is yours';
							$stmt = $con->prepare('UPDATE items SET name = ?, description = ?, price = ?, country = ?, status = ? WHERE item_id = ? '); 
							$stmt->execute(array($name, $desc, $price, $count ,$status ,$item_d));
							$count = $stmt->rowcount();
							if($count > 0){
								echo '<div class="error-id alert alert-success">Update Success</div>';
								redirectpage('','back');
							}			
						}else {
							$error= 'sorry this username is exist</br>';
							echo ' <div class="erro-tow container text-center"><div class="alert alert-dark">';
							redirectpage($error,'back');
							echo '</div></div>';
						}
					}else{
						echo 'no items whith this name';
						$stmtr = $con->prepare('UPDATE items SET name = ?, description = ?, price = ?, country = ?, status = ? WHERE item_id = ? '); 
						$stmtr->execute(array($name, $desc, $price, $count ,$status ,$item_d));
						$count = $stmtr->rowcount();
						redirectpage('','back');
						if($count > 0){
							echo '<div class="error-id alert alert-success">Update Success</div>';
							redirectpage('','back');
						}			
					}
				}
			}else{
				$error = 'you can not browse this page direct </br>';
				echo ' <div class="erro-tow container text-center"><div class="alert alert-dark">';
				redirectpage($error);
				echo '</div></div>';
			}
/*    */}elseif($do == 'delete' ){
				echo '<h2 class="h1 text-center">DELETE item</h2>';
				echo '<div class="container">';

				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
				
				$check = chackusername('item_id','items',$itemid);
				if($check > 0){
					$stmt = $con->prepare('DELETE FROM items WHERE item_id = :zid');
					$stmt->bindparam(':zid', $itemid);
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
/*    */}elseif($_GET['daniels'] == 'approved'){
				echo '<h2 class="h1 text-center">approve items</h2>';
				echo '<div class="container">';

					$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
					
					$check = chackusername('item_id','items',$itemid);
					if($check > 0){
						$stmt = $con->prepare('UPDATE items SET approve = 1 WHERE item_id = ?');
						
						$stmt->execute(array($itemid));
						$count = $stmt->rowcount();
						if($count > 0){
							$error = '<div class="error-id alert alert-success">approve Success</div>';
							redirectpage($error,'back');
						}else{ $error = '<div class="error-id alert alert-danger">approve Error</div>';
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
ob_end_flush();