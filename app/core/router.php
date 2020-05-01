<?php
/**
 * Test task for BeeJee
 * @author Mikhail
 * @link <miksoft.pro>
 */

namespace Core;

/**
 * The class controls navigation between controllers depending on the address bar parameters.
 * Class Loader
 * @package Core
 */
class Router
{

    /**
     * The array contains all available routes
     * @var array
     */
    public $routes = [];

    /**
     * Link to this instance of the class
     * @var type
     */
    private static $instance = null;


    /**
     * The method returns an instance of this class
     * @static
     * @return object this
     */
    static function instance()
    {
        if (self::$instance == NULL)
        {
            self::$instance = new \Core\Router();
        }

        return self::$instance;
    }


    /**
     * This method registers a new route
     * @param type $url route url
     * @param type $template use template in /app/views
     * @param type $controller use controlller in /app/controllers
     * @param type $method use method in controller
     * @return void
     */
    function registration($url, $template, $controller, $method = 'make')
    {
        $this->routes[$url] = [
            'template'   => $template,
            'controller' => $controller,
            'method'     => $method
        ];
    }


    /**
     * The method checks the current address, in case of a match with the address
     * in the route list will take you back an object, otherwise - FALSE.
     * @param string $url url address
     * @return mixed (object) if match or (boolean) FALSE
     */
    function load($url)
    {
        if (empty($url))
        {
            $url = '/';
        }

        if (key_exists($url, $this->routes))
        {
            return (object) $this->routes[$url];
        }

        return false;
    }


    /**
     * Method returns the current address of the page
     * @static
     * @return string
     */
    static function get_uri()
    {
        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);

        $uri = preg_replace('|'.dirname($_SERVER['PHP_SELF']).'|i', '', $uri_parts[0]);
        $uri = str_replace("/", "", $uri);

        return $uri;
    }


    /**
     * Redirect to another page
     * @static
     * @param string $url
     * @param int $code
     */
    static function redirect($url, $code = 303)
    {
        header('Location: ' . $url, TRUE, $code);
        exit();
    }


    /**
     * Detect an AJAX request
     * @static
     * @return boolean
     */
    static function is_ajax()
    {
        if ( ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            return true;
        }

        return false;
    }
}

/* Location: /app/core/router.php */