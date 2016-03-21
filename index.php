<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
//chdir(dirname(__DIR__));
chdir(__DIR__);

set_include_path(implode(PATH_SEPARATOR, 
	array(
		dirname(__FILE__) . DIRECTORY_SEPARATOR . '_zf' . DIRECTORY_SEPARATOR . 'library',
		get_include_path(),
	)
));

defined('APPLICATION_PATH')
	|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/_zf/module/Alice'));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require '_zf/config/application.config.php')->run();
