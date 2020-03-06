<?php 
ob_start();
	$title = "main";
	session_start();

	include "init.php"; ?>
	<div class="container cat">
		<h2 class="h1 text-center">cat name</h2>
		<div class="row">
			<?php 
			$stmt = $con->prepare("SELECT *  FROM items ");
			$stmt->execute(array());
			$fetch = $stmt->fetchall();

			//$it = foritems();
			//$ca = forcat();
				foreach(forcat() as $items){ ?>
					<div class="col-md-3">
						<div class="head"><?php
						
						 	echo $items['name'];
						 
						 ?>
						 	
						</div>
						
						<div class="body">
							<ul><?php
								foreach(foritems($items['cat_id']) AS $cat){
						 	echo '<li><a href="single-item.php?itemid=' . $cat['item_id'] . '">' . $cat['name'] . '</a></li>';
							}
						?>	</ul>
								
						</div>
					</div>
			<?php	}
	 		?>
 		</div>
	</div>
	<?php
	include $templateadmin . "footer.php";
ob_end_flush();
?>