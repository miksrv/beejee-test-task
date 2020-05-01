<?php
/**
 * Test task for BeeJee
 * @author Mikhail
 * @link <miksoft.pro>
 */

namespace Core;

use \Core\View as View;
use \Core\Router as Router;

/**
 * Base class initializes dependencies
 * Class Main
 * @package Core
 */
class Main
{
    /**
     * Reference to the class object 'view'
     * @var object
     */
    public $view;

    function __construct()
    {
        session_start();

        $this->view  = new View();
        $this->initialization();
    }


    /**
     * This method uses the routing class and invokes the appropriate controller
     * @return void
     */
    function initialization()
    {
        $url   = Router::instance()->get_uri();
        $route = Router::instance()->load($url);

        $this->navigate($route);
    }


    /**
     * It is the method of the current route controller
     * @param object $route current route
     * @throws \Exception
     * @return void
     */
    function navigate($route)
    {

        if (empty($route) || ! is_object($route) ||
            ! isset($route->controller) || ! isset($route->method))
        {
            $this->view->show_error_404();
        }

        $controller = $this->_load_controller($route->controller);

        if ( ! method_exists($controller, $route->method))
        {
            throw new \Exception('Controller ' . $route->controller . ' has no method ' . $route->method);
        }

        call_user_func_array([$controller, $route->method], []);

        $this->view->display($route->template);
    }


    /**
     * Loading controller class
     * @access private
     * @param string $controller controller class name
     * @return \Core\class
     */
    private function _load_controller($controller)
    {
        $class = "\Controllers\\{$controller}";

        return new $class($this);
    }
}

/* Location: /app/core/main.php */