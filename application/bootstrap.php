<?php defined('SYSPATH') OR die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link  http://kohanaframework.org/guide/using.configuration
 * @link  http://php.net/timezones
 */
date_default_timezone_set('America/Chicago');

/**
 * Set the default locale.
 *
 * @link  http://kohanaframework.org/guide/using.configuration
 * @link  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link  http://kohanaframework.org/guide/using.autoloading
 * @link  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link  http://php.net/spl_autoload_call
 * @link  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

// Autoload Composer Packages
require __DIR__.'/../vendor/autoload.php';

/**
 * Set the default language
 */
I18n::lang('en-us');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER["KOHANA_ENV"]))
{
	Kohana::$environment = constant("Kohana::".strtoupper($_SERVER["KOHANA_ENV"]));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
	'base_url'   => '',
	'profile'    => TRUE,
	'index_file' => FALSE,
	'caching'    => TRUE,
	'errors'     => TRUE
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	// EXTENSIONS
	// 'jam-resource'               => MODPATH.'extensions/jam-resource',      // Implements resources to connect the Jam models and the routes
	// 'kohana-sitemap'             => MODPATH.'extensions/kohana-sitemap',       // Simple library for generating sitemap

	// EXTERNAL LIBS
	'jam'                        => MODPATH.'jam',
	'jam-auth'                   => MODPATH.'jam-auth',
	// 'jam-taxonomy'               => MODPATH.'jam-taxonomy',
	// 'jam-tart'                   => MODPATH.'jam-tart',
	// 'timestamped-migrations'     => MODPATH.'timestamped-migrations',
	// 'jam-closuretable'           => MODPATH.'jam-closuretable',
	// 'jam-locations'              => MODPATH.'jam-locations',
	// 'services-manager'           => MODPATH.'services-manager',
	// 'jam-monetary'               => MODPATH.'jam-monetary',
	// 'jam-generated-feed'         => MODPATH.'jam-generated-feed',
	// 'jam-freezable'              => MODPATH.'jam-freezable',

	// CORE
	'auth'                       => MODPATH.'core/auth',       // Basic authentication
	'cache'                      => MODPATH.'core/cache',      // Caching with multiple backends
	'database'                   => MODPATH.'core/database',   // Database access
	'image'                      => MODPATH.'core/image',      // Image manipulation
	'minion'                     => MODPATH.'core/minion',      // Image manipulation
));

Cookie::$salt = 'your-secret-salt-here';
Image::$default_driver = 'Imagick';
Session::$default = 'cookie';
HTML::$windowed_urls = TRUE;

Kohana::$shutdown_errors = (PHP_SAPI === 'cli')
	? array()
	: array(E_PARSE, E_ERROR, E_USER_ERROR, E_COMPILE_ERROR);

/**
 * Example configuration of jam-resource.
 * Useful if you don't want to use PUT and DELETE HTTP methods in forms.
 *
 * @var array
 */
// Resource::$actions_map = array(
// 	'collection' => array(
// 		'index'  => 'get',
// 		'new' => array('get', 'post'),
// 	),
// 	'member'     => array(
// 		'show'   => array('get', 'post'),
// 		'edit'   => array('get', 'post', 'put'),
// 		'delete' => array('post', 'delete', 'get')
// 	)
// );

switch (Kohana::$environment)
{
	case Kohana::TESTING:
		include APPPATH.'bootstrap.testing'.EXT;
	break;

	case Kohana::STAGING:
		include APPPATH.'bootstrap.staging'.EXT;
	break;

	case Kohana::DEVELOPMENT:
		include APPPATH.'bootstrap.development'.EXT;
	break;

	case Kohana::PRODUCTION:
		include APPPATH.'bootstrap.production'.EXT;
	break;
}

// Allow groups to edit files
umask(002);

/**
 * Set the routes and the resources. See the HTTP-Resource module for more info.
 * Both routes and resources are being cached and reloaded when the cache has expired.
 * In development and testing environments routes and resources are not cached.
 */
if (in_array(Kohana::$environment, array(Kohana::DEVELOPMENT, Kohana::TESTING)))
{
	include 'routes'.EXT;
}
else
{
	if ( ! Route::cache() OR ! Resource::cache())
	{
		include 'routes'.EXT;

		Route::cache(TRUE);

		Resource::cache(TRUE);
	}
}
