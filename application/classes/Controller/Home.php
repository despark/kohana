<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Homepage.
 */
class Controller_Home extends Controller
{
	function action_index()
	{
		$this->response->body('Hello world!');
	}
}
