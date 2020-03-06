<?php

function lang($paramater) {
	static $lang= array(
		'user' =>	'user',
		'error'	=>	'this is error',
		'more'=>'more',
		'profile'=>'profile',
		'items'=>'items',
		'setting'=>'setting',
		'logout' =>'logout',
		'categories' => 'categories',
		'comment'	=> 'comment',
		'dashbourd'	=> 'dashbourd'

	);
	return $lang[$paramater];
}

