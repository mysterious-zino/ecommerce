<?php

ob_start();
session_start();
$title = "members";

if(isset($_SESSION['user'])){ // request exist
	include 'init.php';

		$do =isset($_GET['daniels']) ? $_GET['daniels'] : 'manage';

/*    */if ($do == 'manage'){ 
		$sort = 'ASC';

		$sortby = array('ASC','DESC');
		if(isset($_GET['sort']) && in_array($_GET['sort'] , $sortby)) {
			$sort = $_GET['sort'];
		}
		$stmt = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY ordering $sort");
		$stmt->execute();
		$fetch = $stmt->fetchall();

	?>
			<h2 class="h1 text-center">Manage Categories</h2>
		 	<div class="container categories">
		 		<div class="card">
		 			<div class="card-header">Manage Categories
		 				<div class="order">Order By :
		 					<a class="view <?php if($sort == 'ASC'){ echo 'active'; } ?>" href="?sort=ASC">ASC</a>
		 					<a class="view <?php if($sort == 'DESC'){ echo 'active'; } ?>" href="?sort=DESC">DESC</a>
		 					View : 
		 					<span class="view " data-view="classic">Classic</span>
		 					<span class="view active" data-view="full">Full</span>
		 				</div>
		 			</div>
		 			<div class="card-body">
		 				 <?php 
		 					foreach ($fetch as $fetchs) {
		 						echo "<div class=categor>";
		 							echo "<div class='button'>";
		 								echo '<a href="categories.php?daniels=edit&catid=' . $fetchs['cat_id'] . '" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>';
		 								echo '<a href="categories.php?daniels=delete&catid=' . $fetchs['cat_id'] . '" class="confirm btn btn-sm btn-danger"><i class="fas fa-times"></i> Delete</a>';
		 							echo "</div>";
			 						echo '<h2>' . $fetchs['name'] . '</h2>';
			 						echo '<div class="box-info">';
				 						if($fetchs['description'] == ''){ echo '<p class="allow">No Description</p>'; }else { echo '<p>' . $fetchs['description'] . '</p>'; }
				 						if($fetchs['visibility'] == 0){ echo '<span class="allow-a">visibel</span>'; }else { echo '<span class="allow-aa">Hidden</span>'; }
				 						if($fetchs['allow_comment'] == 0){ echo '<span class="allow-b">Allow Comment</span>'; }else { echo '<span class="allow-bb">UnAllow Comment</span>'; }
				 						if($fetchs['allow_ads'] == 0){ echo '<span class="allow-c">Allow Ads</span>'; }else { echo '<span class="allow-cc">UnAllow Ads</span>'; }
			 						echo '</div>';
			 						$parents= getall('*', 'categories'," WHERE parent = {$fetchs['cat_id']}" , '', 'cat_id');
		 						echo "</div>"; 
		 						echo "<ul>"; 
		 							foreach($parents as $parent){
		 							echo '<li><a href="categories.php?daniels=edit&catid=' . $parent['cat_id'] . '" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit ' . $parent['name'] . '</a></li>';
		 							}
		 						echo "</ul>"; 

		 						echo "<hr>";
		 					} ?>
		 					
		 				
		 			</div>
		 		</div>
		 		<div class="add"><a class="btn btn-info" href="?daniels=add"><i class="fas fa-plus"></i> Add Categories</a></div>
		 	</div>
		<?php
/*    */}elseif($do == 'add'){ 
			echo '<h2 class="h1 text-center">add category page</h2>'; ?>

			<div class="container">
				<form class="form-horizontal" action="?daniels=insert" method="post">
					<h2 class="h1 text-center">ADD Categories Form</h2>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">name</label>
						<div class="col-sm-10">
							<input type="text" required='required' name="name" class="form-control" autocomplete="nope" placeholder="must be unique">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">description</label>
						<div class="col-sm-10">
							<input type="text" name="description" class="form-control" placeholder="description">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Order By</label>
						<div class="col-sm-10">
							<input  type="text"  name="order" placeholder="" class="form-control">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2 col-form-label">parent</label>
						<div class="col-sm-10">
							<select name="parent">
								<option value="0">none</option>
								<?php
								$fetchall = getall('*', 'categories', 'WHERE parent = 0', NULL, 'name');
								foreach($fetchall as $fetch){
									echo '<option value="'. $fetch['cat_id'] .'">'. $fetch['name'] .'</option>';
								}
								?>

							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2 col-form-label">visibility</label>
						<div class="col-sm-10">
							<div>
								<input id="vis-yes" type="radio" checked name="visibility" value="0">
								<label for="vis-yes">Yes</label>
							</div>
							<div>
								<input id="vis-no" type="radio" name="visibility" value="1">
								<label for="vis-no">No</label>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Show comments</label>
						<div class="col-sm-10">
							<div>
								<input id="comment-yes" type="radio" checked name="comments" value="0">
								<label for="comment-yes">Yes</label>
							</div>
							<div>
								<input id="comment-no" type="radio" name="comments" value="1">
								<label for="comment-no">No</label>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Show ads</label>
						<div class="col-sm-10">
							<div>
								<input id="ads-yes" type="radio" checked name="ads" value="0">
								<label for="ads-yes">Yes</label>
							</div>
							<div>
								<input id="ads-no" type="radio" name="ads" value="1">
								<label for="ads-no">No</label>
							</div>
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
			echo '<h2 class="h1 text-center">this is insert page</h2>';
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$user 		= $_POST['name'];
				$describ 	= $_POST['description'];
				$order 		= $_POST['order'];
				$parent 	= $_POST['parent'];
				$visi 		= $_POST['visibility'];
				$comment 	= $_POST['comments'];
				$ads 		= $_POST['ads'];
					
					if(empty($user)){
						echo '<div class="alert alert-danger">name can not be empty</div>';
						redirectpage('','back');
					}else{
						$check = chackusername('name','categories',$user);
						if($check == 1){
							$error= 'sorry this Name is exist</br>';
							echo ' <div class="erro-tow container text-center"><div class="alert alert-dark">';
							redirectpage($error,'back');
							echo '</div></div>';
						}else{
							$stmt = $con->prepare("INSERT INTO categories(name, description, ordering, parent, visibility,allow_comment,allow_ads ,date)
													VALUES (:namekey, :disckey ,:orderkey, :zparent, :visikey, :commkey, :adskey, now())");
							$stmt->execute(array(
								'namekey' => $user,
								'disckey' => $describ,
								'orderkey'=> $order,
								'zparent' => $parent,
								'visikey' => $visi,
								'commkey' => $comment,
								'adskey'  => $ads
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
			$userid = isset($_GET["catid"]) && is_numeric($_GET["catid"]) ? intval($_GET["catid"]) : 0 ;
			$stmt = $con->prepare("SELECT * FROM categories WHERE cat_id = ?");
			$stmt->execute(array($userid));
			$fetch= $stmt->fetch(); 
			$count = $stmt->rowcount();
			if ($count == 1) {
?>
			<div class="container">
				<form class="form-horizontal" action="?daniels=update" method="post">
					<input type="hidden" name="cat_id" value="<?php echo $fetch['cat_id'] ?>">
					<h2 class="h1 text-center">Update Categories Form</h2>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">name</label>
						<div class="col-sm-10">
							<input type="text" required='required' name="name" class="form-control"  placeholder="must be unique" value="<?php echo $fetch['name']?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">description</label>
						<div class="col-sm-10">
							<input type="text" name="description" class="form-control" placeholder="description" value="<?php echo $fetch['description']?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Order By</label>
						<div class="col-sm-10">
							<input  type="text"  name="order" placeholder="" class="form-control" value="<?php echo $fetch['ordering']?>">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2 col-form-label">parent</label>
						<div class="col-sm-10">
							<select name="parent">
								<option value="0">none</option>
								<?php
								$fetchall = getall('*', 'categories', 'WHERE parent = 0', NULL, 'name');
								foreach($fetchall as $fet){
									echo '<option value="' . $fet['cat_id'] . '"'; if($fetch['parent'] == $fet['cat_id']){ echo 'selected'; }echo '>'. $fet['name'] .'</option>';

								}
								?>

							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2 col-form-label">visibility</label>
						<div class="col-sm-10">
							<div>
								<input id="vis-yes" type="radio" <?php if($fetch['visibility'] == 0){ echo 'checked'; } ?>  name="visibility" value="0">
								<label for="vis-yes">Yes</label>
							</div>
							<div>
								<input id="vis-no" type="radio" <?php if($fetch['visibility'] == 1){ echo 'checked'; } ?> name="visibility" value="1">
								<label for="vis-no">No</label>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Show comments</label>
						<div class="col-sm-10">
							<div>
								<input id="comment-yes" type="radio"  name="comments" value="0" <?php if($fetch['allow_comment'] == 0){ echo 'checked'; } ?>>
								<label for="comment-yes">Yes</label>
							</div>
							<div>
								<input id="comment-no" type="radio" name="comments" value="1" <?php if($fetch['allow_comment'] == 1){ echo 'checked'; } ?>>
								<label for="comment-no">No</label>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Show ads</label>
						<div class="col-sm-10">
							<div>
								<input id="ads-yes" type="radio"  name="ads" value="0" <?php if($fetch['allow_ads'] == 0){ echo 'checked'; } ?>>
								<label for="ads-yes">Yes</label>
							</div>
							<div>
								<input id="ads-no" type="radio" name="ads" value="1" <?php if($fetch['allow_ads'] == 1){ echo 'checked'; } ?>>
								<label for="ads-no">No</label>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="offset-sm-2 col-sm-10">
							<input type="submit" value="SAVE" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>

			</div>

		<?php }else { $error = 'you can not browse this page direct </br>';
				echo ' <div class="erro-tow container text-center"><div class="alert alert-dark">';
				redirectpage($error);
				echo '</div></div>'; }
			
/*    */}elseif($do == 'update'){  // if update 
			echo '<h2 class="h1 text-center">Update User</h2>';
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$cat_id		= $_POST['cat_id'];
				$name		= $_POST['name'];
				$desc		= $_POST['description'];
				$ore		= $_POST['order'];
				$parent 	= $_POST['parent'];
				$visi		= $_POST['visibility'];
				$comment	= $_POST['comments'];
				$ads		= $_POST['ads'];
				if(empty($name)){
						echo '<div class="alert alert-danger">name can not be empty</div>';
						redirectpage('','back');
				}else{
					$check = chackusername('name','categories',$name);
					if ($check == 1){
						$checkid = chackupdate('name','cat_id','categories',$name,$cat_id);
						if($checkid == 1){
							$stmt = $con->prepare('UPDATE categories SET name = ?, description = ?, ordering = ?,parent = ?, visibility = ?, allow_comment = ?, allow_ads = ? WHERE cat_id = ? '); 
							$stmt->execute(array($name, $desc, $ore, $parent, $visi ,$comment ,$ads ,$cat_id));
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
						$stmt = $con->prepare('UPDATE categories SET name = ?, description = ?, ordering = ?, visibility = ?, allow_comment = ?, allow_ads = ? WHERE cat_id = ? '); 
						$stmt->execute(array($name, $desc, $ore, $visi ,$comment ,$ads ,$cat_id));
						$count = $stmt->rowcount();
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
			echo '<h2 class="h1 text-center">DELETE categories</h2>';
			echo '<div class="container">';

			$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
			
			$check = chackusername('cat_id','categories',$catid);
			if($check > 0){
				$stmt = $con->prepare('DELETE FROM categories WHERE cat_id = :zid');
				$stmt->bindparam(':zid', $catid);
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
/*    */}else{echo 'error';}	// else update

	include $templateadmin . "footer.php";
}else {  // request not exist
		header('location:index.php');
		exit();
}
ob_end_flush();