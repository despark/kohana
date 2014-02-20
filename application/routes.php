<?php defined('SYSPATH') OR die('No direct script access.');

Route::set('home', '')
	->defaults(array(
		'controller' => 'Home',
		'action' => 'index'
	));
