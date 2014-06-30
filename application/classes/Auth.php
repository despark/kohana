<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * User authorization library. Handles user login and logout, as well as secure
 * password hashing.
 *
 * @package    Kohana/Auth
 * @author     Kohana Team
 * @copyright  (c) 2007-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Auth extends Kohana_Auth {

	public function check_password($password)
	{
		$user = $this->get_user();

		if ( ! $user) {
			return false;
		}

		return password_verify($password, $this->hash($password));
	}

	/**
	 * Perform a hmac hash, using the configured method.
	 *
	 * @param   string  $str  string to hash
	 * @return  string
	 */
	public function hash($str)
	{
		if ( ! $this->_config['hash_algorihtm'])
			throw new Kohana_Exception('A valid hash algorithm must be set in your auth config.');

		return password_hash(
			$str,
			$this->_config['hash_algorihtm'],
			Arr::get($this->_config, 'hash_options', array())
		);
	}

} // End Auth
