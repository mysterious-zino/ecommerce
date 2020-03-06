<?php



function title(){
	global $title;
	if(isset($title)){
		echo $title;
	}else {
		echo 'default';
	}
}
/***************************************************************
**
**  				items " order by " from database home
**
****************************************************************/

function lastuscat(){
		global $con;
		$stmt_e = $con->prepare("SELECT * FROM categories WHERE parent = 0");
		$stmt_e->execute();
		
		return $stmt_e->fetchall();
}
function lastitem($id, $item_id){
		global $con;
		$stmt_e = $con->prepare("SELECT * FROM items WHERE $id = ? ORDER BY item_id DESC");
		$stmt_e->execute(array($item_id));
		
		return $stmt_e->fetchall();
}
function chackstatus($value){
	global $con;
	$stmt_f = $con->prepare("SELECT username, reg_status FROM users WHERE username = ? AND reg_status = 0");
	$stmt_f->execute(array($value));
	$status = $stmt_f->rowcount();
	return $status;
}
function getitem($where, $select, $approve = NULL){
	global $con;
	if($approve == NULL){
		$app = "AND approve = 1";
	}else {
		$app = NULL;
	}
	$stmt = $con->prepare("SELECT * FROM items WHERE $where = ? $app ORDER BY add_date DESC");
	$stmt->execute(array($select));
	$fetch = $stmt->fetchall();
	return $fetch;
}
function forcat(){
	global $con;
	$stmt = $con->prepare("SELECT DISTINCT categories.* FROM categories INNER JOIN(SELECT DISTINCT cat_id,add_date from items) items ON items.cat_id = categories.cat_id ORDER by add_date DESC");
	$stmt->execute();
	$fetch = $stmt->fetchall();
	return $fetch;
	}
function foritems($id){
	global $con;
	$stmt = $con->prepare("SELECT *  FROM items WHERE cat_id = ? ORDER BY add_date DESC LIMIT 3 ");
	$stmt->execute(array($id));
	$fetch = $stmt->fetchall();
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