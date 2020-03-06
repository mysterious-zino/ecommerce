<?php
ob_start("ob_gzhandler");
session_start();
$title = "dashbourd";

if(isset($_SESSION['user'])){
		include 'init.php'; 
		$usernum 	= 5;
		$latstuser  = itemsorder('username,user_id','users','user_id ASC',$usernum);
		$itemnum	= 5;
		$latstitem  = itemsorder('*','items','add_date DESC',$itemnum);
		
		?>

<div class="dashbourd">
<h2 class="h1 text-center">DAshbourd Page</h2>
	<div class="panal-dash text-center">
		
		<div class="container text-center">
			<div class="row">
				<div class="col-md-3">
					<div class="count totale">
						<i class=" fas fa-users"></i>
						<div class="counts">totale members
							<a href="members.php?"><span><?php echo countuser('user_id','users',null); ?></span></a>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="count pending">
						<i class=" fas fa-user-plus"></i>
						<div class="counts">
						Pending
						<a href="members.php?daniels=manage&deactiv=panding"><span><?php echo countuser('reg_status','users','WHERE reg_status = 0'); ?></span></a>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="count items">
						<i class=" fas fa-tag"></i>
						<div class="counts">
							totale items
							<a href="items.php?"><span><?php echo countuser('item_id','items',null); ?></span></a>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="count comment">
						<i class=" fas fa-comment"></i>
						<div class="counts">
						totale comments
						<a href="comments.php?"><span><?php echo countuser('co_id','comment',null); ?></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="latest">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="card panel-default">
						<div class="card-header"><i class="fas fa-users"></i> Latse <?php echo $usernum; ?> Register Users<span class="float-right toggel-info"><i class="fas fa-minus "> </i></span></div>
						<div class="card-body">
							<ul class="list-unstyled list table-striped table-dark">
							<?php foreach($latstuser as $users){
						 echo '<li><i class="fas fa-user"></i> ' . $users['username'] . '<a href="members.php?daniels=edit&userid=' . $users['user_id'] . '"><span class="btn btn-success float-right"><i class="fas fa-edit"></i> Edit</span></a></li>';} ?>
						 	</ul>
						 </div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card panel-default">
						<div class="card-header"><i class="fas fa-tags"></i> Latse <?php echo $itemnum; ?> Items<span class="float-right toggel-info"><i class="fas fa-minus "> </i></span></div>
						<div class="card-body">
							<ul class="list-unstyled list table-striped table-dark">
							<?php foreach($latstitem as $items){
						 echo '<li><i class="fas fa-user"></i> ' . $items['name'] ;
						 if($items['approve'] == 0){
						 	echo ' <a href="items.php?daniels=approved&userid=' . $items['item_id'] . '"> <span class="btn btn-info float-right"><i class="fas fa-check"></i> approve</span></a>';
						 }

						 echo '<a href="items.php?daniels=edit&itemid=' . $items['item_id'] . '"><span class="btn btn-success float-right"><i class="fas fa-edit"></i> Edit</span></a></li>' ;} ?>
						 	</ul>
						 </div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="card panel-default">
						<div class="card-header">
							<i class="fas fa-users"></i> Latse <?php echo $usernum; ?> Register Users
							<span class="float-right toggel-info">
								<i class="fas fa-minus "> </i>
							</span>
						</div>
						<div class="card-body">
							<?php 
								$stmt=$con->prepare("SELECT comment.*,users.username FROM comment INNER JOIN users ON users.user_id = comment.user_id");
								$stmt->execute();
								$comments = $stmt->fetchAll();
								if(!empty($comments)){
									foreach($comments as $comment){
										echo '<div class="comment-box">';
										echo '<a href="members.php?daniels=edit&userid=' . $comment['user_id'] . '"><span class="member-n">' . $comment['username'] . '</span></a>';
										echo '<p class="member-c">' . $comment['comment'] . '</p>';
										echo '</div>';
										echo '<a href="comments.php?daniels=edit&coid=' . $comment['co_id'] . '" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
											<a href="comments.php?daniels=delete&coid=' . $comment['co_id'] . '" class="btn btn-danger confirm"><i class="fas fa-times"></i> delete</a>';
											if($comment['co_status'] == 0){
									echo   '<a href="comments.php?daniels=approve&coid=' .  $comment['co_id'] . '" class="btn btn-info btn-act"><i class="fas fa-question"></i> Active</a>';
											}else { echo '<a href="#" class="disabled btn btn-info btn-act"><i class="fas fa-check"></i> DEAct</a>'; }
									}
								}
							?>
							
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card panel-default">
						<div class="card-header"><i class="fas fa-tags"></i> Latse <?php echo $itemnum; ?> Items<span class="float-right toggel-info"><i class="fas fa-minus "> </i></span></div>
						<div class="card-body">
							<ul class="list-unstyled list table-striped table-dark">
							<?php foreach($latstitem as $items){
						 echo '<li><i class="fas fa-user"></i> ' . $items['name'] ;
						 if($items['approve'] == 0){
						 	echo ' <a href="items.php?daniels=approved&userid=' . $items['item_id'] . '"> <span class="btn btn-info float-right"><i class="fas fa-check"></i> approve</span></a>';
						 }

						 echo '<a href="items.php?daniels=edit&itemid=' . $items['item_id'] . '"><span class="btn btn-success float-right"><i class="fas fa-edit"></i> Edit</span></a></li>' ;} ?>
						 	</ul>
						 </div>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>



		
	

<?php	include $templateadmin . "footer.php";
}else {
		header('location:index.php');
		exit();
}
ob_end_flush();