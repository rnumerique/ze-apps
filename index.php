<?php
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

switch (ENVIRONMENT) {
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;

    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        if (version_compare(PHP_VERSION, '5.3', '>=')) {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        } else {
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        }
        break;

    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1); // EXIT_ERROR
}


// System Folder
$system_path = 'system';


// Set the current directory correctly for CLI requests
if (defined('STDIN')) {
    chdir(dirname(__FILE__));
}

if (($_temp = realpath($system_path)) !== FALSE) {
    $system_path = $_temp . DIRECTORY_SEPARATOR;
} else {
    // Ensure there's a trailing slash
    $system_path = strtr(
            rtrim($system_path, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
        ) . DIRECTORY_SEPARATOR;
}

// Is the system path correct?
if (!is_dir($system_path)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: ' . pathinfo(__FILE__, PATHINFO_BASENAME);
    exit(3); // EXIT_CONFIG
}


// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// Path to the system folder
define('BASEPATH', str_replace('\\', '/', $system_path));

// Path to the front controller (this file)
define('FCPATH', dirname(__FILE__) . '/');

// Name of the "system folder"
define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));

define('MODULEPATH', dirname(__FILE__) . '/modules/');


// autoload
require_once FCPATH . 'autoload.php';


// appel de la classe routeur
$routeur = new ZeRouteur();

// charge le controller
    if ($routeur->module == 'ng'){
        // All /ng/* urls are angular urls, so we load the app and let angular deal with it
        $controllerPath = BASEPATH . 'controllers/app.php';
        $routeur->controller = 'App';
        $routeur->function = 'index';
    }
    elseif ($routeur->module == 'zeapps') {
        // App core controllers
        $controllerPath = BASEPATH . 'controllers/' . ucfirst($routeur->controller) . '.php';
    }
    else {
        $controllerPath = MODULEPATH . $routeur->module . '/controllers/' . ucfirst($routeur->controller) . '.php';
    }

// verifie que le controller existe
    if (is_file($controllerPath)) {
        require_once $controllerPath;

        $ctrlName = ucfirst($routeur->controller);
        $controller = new $ctrlName();

        if (method_exists($ctrlName, $routeur->function)) {
            call_user_func_array(array($controller, $routeur->function), $routeur->params);
        } else {
            header('HTTP/1.1 404 Not Found', TRUE, 404);
            echo 'Page Not Found. Unknow function';
            exit(1); // EXIT_ERROR
        }
    } else {
        header('HTTP/1.1 404 Not Found', TRUE, 404);
        echo 'Page Not Found. Unknow controller';
        exit(1); // EXIT_ERROR
    }
