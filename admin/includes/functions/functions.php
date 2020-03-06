<?php



function title(){
	global $title;
	if(isset($title)){
		echo $title;
	}else {
		echo 'default';
	}
}
function getall($select, $table, $where = NULL, $and = NULL, $orderby ,$order = 'DESC'){
	global $con;
	$stmt =$con->prepare("SELECT $select FROM $table $where $and ORDER BY $orderby $order");
	$stmt->execute(array());
	$fetch=$stmt->fetchall();
	return $fetch;
}

/*********************************************************************
**
**                              function redarict home
**
**************************************************************************/
//------------------ function redarict v.1-------------------------------
/*
function redirecthome($error ,$second = 3){
	echo $error ;
	echo "you will be redirect to home after $second second";
	header("refresh:$second;url=index.php");
	exit();
}
function redirectadd($error ,$second = 3){
	echo $error ;
	echo "please try again after $second second";
	header("refresh:$second;url=members.php?daniels=add");
	exit();
}
function redirectedit($error ,$second = 3){
	global $id; 

	echo $error ;
	echo "please try after $second second";
	header("refresh:$second;url=members.php?daniels=edit&userid=$id");
	exit();
}
function redirectuser($second = 3){
	header("refresh:$second;url=members.php?daniels=manage");
	exit();
} */
function redirectpage($themas, $link=null, $second=4){
	echo $themas;
	if($link === null){
		$url = 'index.php';
	}else{
		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !==''){
			$url = $_SERVER['HTTP_REFERER'];
		}else { $url = 'index.php'; }
	}
	header("refresh:$second;url=$url");
}

/***************************************************************
**
**  						chack Username from database home
**
****************************************************************/

function chackusername($username, $from, $value){
	global $con;
	$stmt_b = $con->prepare("SELECT $username FROM $from WHERE $username = ?");
	$stmt_b->execute(array($value));
	$chack = $stmt_b->rowcount();
	return $chack;
}
function chackupdate($username,$id, $from, $value, $valueb){
	global $con;
	$stmt_b = $con->prepare("SELECT $username ,$id FROM $from WHERE $username = ? AND  $id = ?");
	$stmt_b->execute(array($value,$valueb));
	$chack = $stmt_b->rowcount();
	return $chack;
}


function countuser($item,$table,$num){
	global $con;
	$stmt_c = $con->prepare("SELECT COUNT($item) FROM $table  $num ");
	$stmt_c->execute();
	$count = $stmt_c->fetchcolumn();
	return $count;
}/*
function countpending($item,$table,$num){
	global $con;
	$stmt_c = $con->prepare("SELECT COUNT($item) FROM $table WHERE $item = $num");
	$stmt_c->execute();
	$count = $stmt_c->fetchcolumn();
	return $count;
}*/

/***************************************************************
**
**  				items " order by " from database home
**
****************************************************************/

function itemsorder($select, $from, $orderbay, $limit = 4){
		global $con;
		$stmt_e = $con->prepare("SELECT $select FROM $from ORDER BY $orderbay LIMIT $limit");
		$stmt_e->execute();
		
		return $stmt_e->fetchall();
}