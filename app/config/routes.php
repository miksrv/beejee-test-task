<?php
/**
 * Test task for BeeJee
 * @author Mikhail
 * @link <miksoft.pro>
 */

use \Core\Router as Router;

/**
 * In this file we register static routes.
 * When adding a new route, specify the parameters:
 * 1. URL - page link
 * 2. Template - PHP view file in DIR_VIEW
 * 3. Controller - PHP controller file in DIR_CONTROLLERS
 * 4. Method - index method in controller
 */

Router::instance()->registration('/', 'index.php', 'Index');
Router::instance()->registration('save', 'index.php', 'Index', 'save');
Router::instance()->registration('login', 'login.php', 'Login');
Router::instance()->registration('auth', 'login.php', 'Login', 'auth');
Router::instance()->registration('logout', 'login.php', 'Login', 'logout');

/* Location: /app/config/routes.php */