<?php



ini_set('display_errors','on');
error_reporting(E_ALL);

include 'admin/config.php';
//include 'page.php';
$sess = '';
if(isset($_SESSION['username'])){
	$sess = $_SESSION['username']; 
}

$templateadmin 	= "includes/template/";
$func			= "includes/functions/";
$cssadmin		= "layout/css/";
$jsadmin		= "layout/js/";
$langadmin		= "includes/languages/";

/* include importent files */
include $func . "functions.php";
include $langadmin . 'english.php';
include $templateadmin . "header.php";
include $templateadmin . "navbar.php";



