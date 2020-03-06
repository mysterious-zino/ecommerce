<?php

include 'config.php';
//include 'page.php';

$templateadmin 	= "includes/template/";
$func			= "includes/functions/";
$cssadmin		= "layout/css/";
$jsadmin		= "layout/js/";
$langadmin		= "includes/languages/";

/* include importent files */
include $func . "functions.php";
include $langadmin . 'english.php';
include $templateadmin . "header.php";
if(!isset($nonav)){include $templateadmin . "navbar.php";}





