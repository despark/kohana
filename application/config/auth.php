<?php defined('SYSPATH') OR die('No direct script access.');

return array(
	'driver' => 'jam',
	'hash_algorithm' => PASSWORD_BCRYPT,
	'hash_options' => array(
		'cost' => 10,
	),
	'lifetime'     => 1209600,
	'session_type' => Session::$default,
	'session_key'  => 'auth_user',

	'services' => array(
		'facebook' => array(
			'enabled' => TRUE,
			'auto_login' => FALSE,
			'create_user' => TRUE,
			'auth' => Arr::get(array(
				Kohana::PRODUCTION => array(
					'appId' => '',
					'secret' => ''
				),
				Kohana::STAGING => array(
					'appId' => '',
					'secret' => ''
				),
				Kohana::DEVELOPMENT => array(
					'appId' => '',
					'secret' => ''
				)
			), Kohana::$environment)
		),
		'twitter' => array(
			'enabled' => FALSE,
			'auth' => array(
				'consumer_key' => 'YOUR_CONSUMER_KEY',
				'consumer_secret' => 'YOUR_CONSUMER_SECRET',
			),
			'create_user' => TRUE,
		),
	),

);
