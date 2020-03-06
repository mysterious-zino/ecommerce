<?php 


ob_start(); $title = "categories"; session_start(); include "init.php";  ?>


	
	<div class="container cat">
		<h2 class="h1 text-center">cat name</h2>
		<div class="row">
			<?php 
				foreach(getitem('cat_id' ,$_GET['pageid']) as $items){
					echo '<div class="col-md-3 col-sm-6">' ;
						echo '<div class="img-thumbnail box-item">' ;
						echo '<span class="price">' . $items['price'] . '</span>';
							echo '<img  class="img-fluid" src="layout/images/dani.jpg">';
							echo '<div class="caption">' ;
								echo  '<h3><a href="single-item.php?itemid=' . $items['item_id'] . '">' . $items['name'] . '</a></h3>';
								echo  '<p>' . $items['description'] . '</p>';
								echo  '<span class="date">' . $items['add_date'] . '</span>';
							echo '</div>';
						echo '</div>' ;
					echo '</div>';
				}
	 		?>
 		</div>
	</div>
	<img src="">
	
	
<?php	include $templateadmin . "footer.php"; ob_end_flush(); ?>