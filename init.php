<?php

/**
 * Add Composer autoloader.
 */
require_once 'vendor/autoload.php';

include_once 'Logger.php';

ini_set("session.cookie_domain", ".lotoluck.com");

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";


define('SITE_PROTOCOL',		$protocol);

define('TEMPLATE_NAME','default_template');
define('PROJECT_ROOT_PATH','/');

//define('SITE_PATH',		"{$protocol}lotoluck.com/");
//define('SITE_SSL_PATH',		"https://lotoluck.com/");
#define('SITE_PATH',		"http://lotoluck.com/");
define('SITE_PATH', $protocol.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/');
define('SITE_SSL_PATH', 'https://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/');

define('REDIRECT_PATH', $protocol.$_SERVER['SERVER_NAME'].'/');

define('FILE_ACCESS_PATH',"");
define('SYSTEM_LANGUAGE',"es");

$ua = isset($_SERVER['HTTP_USER_AGENT'])
               ? $_SERVER['HTTP_USER_AGENT']
               : '';
define('USER_AGENT',$ua);


//-->timer
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

//-->initalization wrapper
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

/**
* If we are in admin layer, the root path changes.
*/
if( defined('IN_ADMIN') ){
	$root = '../';
}else{
	$root = '';
}
/*some global vars*/
$dbdriver = 'mysql';
$loaded = false;
$gzip = true;

@define('IN_PROJECT',true);
$project_path = (defined('PROJECT_ROOT_PATH')) ? PROJECT_ROOT_PATH : $root;
$phpEx = substr(strrchr(__FILE__, '.'), 1);
//@define('DEBUG_EXTRA',true);
@define(TBL_PREFIX ,'');
ini_set('upload_max_filesize','320M');

/*now we really define*/
@define(ADMIN_FLDR_NAME, 'admin');//$root.
@define(ADMIN_FLDR_PATH, $root.'admin');//$root.
@define(PATH_TEMPLATE, 'template/'.TEMPLATE_NAME.'/');
@define(ADMIN_PATH_TEMPLATE, ADMIN_FLDR_PATH.'/template/'.TEMPLATE_NAME.'/');
@define(PATH_KERNEL,$root.'kernel/');
@define(INCLUDES,$root.'includes/');
@define(DESCARGAS_PATH,$root.'descargas/');
@define(INCLUDES_MODULOS,$root.'includes_modulos/');
@define(GLOBAL_LIBS ,PATH_KERNEL.'agllib/');
@define(SERVICIOS_EXTERNOS,$root.'utils/');
#@define(SESSION_NAME,$root.'utils/');

@define(SESSION_NAME ,'session_ll_2021');
@define(COOKIES_JUEGOS_NAME ,'lotoluckjuegoshome');
@define(MEDIA_FILES ,$root.'media/');

/**
*
*/

global $user_platform;
$user_platform = 'desktop';
if((strpos(USER_AGENT, 'iPhone') !== FALSE
	|| strpos(USER_AGENT, 'iPod') !== FALSE
	|| strpos(USER_AGENT, 'iPad') !== FALSE )
){
	$user_platform = 'ios';
}

if((strpos(USER_AGENT, 'android') !== FALSE )
	&&
	($config['url_red_android'] != 'web')
){
	$user_platform = 'android';
}

/*
//$vars['mensaje_u'] = $_SESSION['mensaje_u'];
* Remove variables created by register_globals from the global scope
* Thanks to Matt Kavanagh
*/
function deregister_globals(){
	$not_unset = array(
		'GLOBALS'		=> true,
		'_GET'			=> true,
		'_POST'			=> true,
		'_COOKIE'		=> true,
		'_REQUEST'		=> true,
		'_SERVER'		=> true,
		'_SESSION'		=> true,
		'_ENV'			=> true,
		'_FILES'		=> true,
		'phpEx'			=> true,
		'project_path'	=> true,
	);

	// Not only will array_merge and array_keys give a warning if
	// a parameter is not an array, array_merge will actually fail.
	// So we check if _SESSION has been initialised.
	if (!isset($_SESSION) || !is_array($_SESSION)){
		$_SESSION = array();
	}

	// Merge all into one extremely huge array; unset this later
	$input = array_merge(
		array_keys($_GET),
		array_keys($_POST),
		array_keys($_COOKIE),
		array_keys($_SERVER),
		array_keys($_SESSION),
		array_keys($_ENV),
		array_keys($_FILES)
	);

	foreach ($input as $varname){
		if (isset($not_unset[$varname])){
			// Hacking attempt. No point in continuing.
			exit;
		}
		unset($GLOBALS[$varname]);
	}
	unset($input);
}

// If we are on PHP >= 6.0.0 we do not need some code
if (version_compare(PHP_VERSION, '6.0.0-dev', '>=')){
	/**
	* @ignore
	*/
	define('STRIP', false);
}else{
	#if(function_exists("set_magic_quotes_runtime")){
	#set_magic_quotes_runtime(0);
	#}

	// Be paranoid with passed vars
	if (@ini_get('register_globals') == '1' || strtolower(@ini_get('register_globals')) == 'on'){
		deregister_globals();
	}

	define('STRIP', (get_magic_quotes_gpc()) ? true : false);
}

if (defined('DEBUG_EXTRA')){
	$base_memory_usage = 0;
	if (function_exists('memory_get_usage')){
		$base_memory_usage = memory_get_usage();
	}
}

/*lets include our sttuf*/
require(GLOBAL_LIBS.'lib/funciones.php');
require(GLOBAL_LIBS.'lib/html.php');
require(GLOBAL_LIBS."lib/class.cache.php");
require(GLOBAL_LIBS."bd/{$dbdriver}.php");

/*seleccionamos datos de la bbdd segun la zona donde estemos*/
require_once(PATH_KERNEL."dbconfig.php");

require_once(PATH_KERNEL."constants.php");
require_once(PATH_KERNEL."functions.php");

require_once(PATH_KERNEL."settings.php");

/**
 * Add custom configuration override
 */
if (file_exists($root.'settings.env.php')) {
	require_once $root.'settings.env.php';
}


/*global classes*/
$cache = new cache();

/* Set PHP error handler to ours*/
set_error_handler('msg_handler');

/*
* set the vars passed thru POST and GET HTTP data
*/
$vars = parse_incoming();

/*
* luis
*/

$vars['login_error']	=	$_SESSION['login_error'];
$_SESSION['login_error']=	'';
$vars['mensaje_u']		=	$_SESSION['mensaje_u'];
$_SESSION['mensaje_u']	=	'';
$vars['mensaje_error']	=	$_SESSION['mensaje_error'];
$_SESSION['mensaje_error']	=	'';

$vars['juego_seleccionado_raw'] = $vars['juego_seleccionado'];

/*
* load the database layer
*/
$db = new $sql_db;

/*connect to the database*/
$db->conectar( $dbconfig['server'], $dbconfig['username'], $dbconfig['password'], $dbconfig['database'], $dbconfig['port'] );

/*get the config*/
$config = loadconfig('all');

/*is the site offline?*/

if( $config['maintenance'] ){
	//-->init dicconario
	$lang = loadLangFile('public',SYSTEM_LANGUAGE);

	trigger_error("This site is offline due to maintenance", E_USER_ERROR);
}
$lang = loadLangFile('admin',SYSTEM_LANGUAGE);

require_once(PATH_KERNEL."xtra_config_data.php");
require_once(INCLUDES."constantes.php");



?>