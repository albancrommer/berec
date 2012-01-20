<?

error_reporting( E_ALL );
ini_set('display_errors', 1 );
set_include_path('./library/');

// Set default session length to 5 hours
ini_set("session.gc_maxlifetime", "18000"); 

// Define timezone
date_default_timezone_set('Europe/Paris');

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// include environment
require_once(APPLICATION_PATH.'/configs/env.php');

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', ( $env ? $env : 'staging'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library/'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';  

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV, 
    APPLICATION_PATH . '/configs/application.ini'
);
try {
    $application->bootstrap()->run();
} catch (Exception $e) {
    echo('<h1>Critical error</h1>');
    if( APPLICATION_ENV == "development"){
        var_dump($e);
    }
}

?>