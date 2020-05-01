<?php
/**
 * Test task for BeeJee
 * @author Mikhail
 * @link <miksoft.pro>
 */

    define(DEBUG, true);

    define(DIR_ROOT, __DIR__ . '/');
    define(DIR_APP, DIR_ROOT . 'app/');


    if (DEBUG) {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
    }

    define('DIR_VIEW', DIR_APP . 'views/');

    define('DIR_LIBRARIES', DIR_APP . 'libraries/');
    define('DIR_CONTROLLERS', DIR_APP . 'controllers/');
    define('DIR_MODELS', DIR_APP . 'models/');
    define('DIR_CORE', DIR_APP . 'core/');
    define('DIR_CONFIG', DIR_APP . 'config/');
    define('DIR_CONTENT', DIR_APP . 'data/');

    require_once DIR_CORE . 'loader.php';

    /**
     * Autoloader initialization
     */
    $LOADER = new \Core\Loader();

    spl_autoload_register(array($LOADER, 'autoload'));

    /**
     * Loading router card
     */
    require_once DIR_CONFIG . 'routes.php';

    $controller = new \Core\Main();