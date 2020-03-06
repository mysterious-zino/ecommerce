<?php

$do =isset($_GET['daniels']) ? $_GET['daniels'] : 'manage';



if ($do == 'manage'){
	echo 'welcom to manage page';
}elseif($do == 'add'){
	echo 'welcom to add page';

}elseif($do == 'edit'){
	echo 'welcom to edit page';
	echo '<a href="?daniels=add">click here to add page + +</a>';
}else{
	$do ='manage';
}


