<?php
/**
 * Test task for BeeJee
 * @author Mikhail
 * @link <miksoft.pro>
 */

namespace Core;

use \Core\Router as Router;

/**
 * The base view class, loads and executes template files
 * Class View
 * @package Core
 */
class View
{
    /**
     * Array of template variables
     * @var array
     */
    private $variables = [];

    /**
     * HTTP server statuses codes
     * @var array
     */
    private $http_header_codes = [
        200 => '200 OK',
        301 => '301 Moved Permanently',
        303 => '303 See Other',
        307 => '307 Temporary Redirect',
        401 => '401 Unauthorized',
        403 => '403 Forbidden',
        404 => '404 Not Found'
    ];

    /**
     * Template for page 404
     * @var string
     */
    private $page_404_template 	= '404.php';


    /**
     * Display page using the specified template
     * @throws \Exception
     * @param string template name
     * @return void
     */
    function display($template)
    {
        if ( ! $this->_template_exists(DIR_VIEW . $template))
        {
            throw new \Exception('Template file not exists (' . $template . ')');
        }

        $this->_print_template(DIR_VIEW . $template);
    }


    /**
     * Returns the server's response in json format
     * @throws \Exception
     * @param array
     * @return void
     */
    function json($data)
    {
        if ( ! is_array($data))
        {
            throw new \Exception('No input array');
        }

        header('Content-Type: application/json');
        print(json_encode($data));

        exit();
    }


    /**
     * Show template page 404
     * @return void
     */
    function show_error_404()
    {
        if ( ! empty($this->page_404_template) && $this->_template_exists(DIR_VIEW . $this->page_404_template))
        {
            $this->_print_template(DIR_VIEW . $this->page_404_template, 404);
        }

        Router::redirect('/');
    }


    /**
     * Assign a variable to the view
     * @param string variable
     * @param string value
     * @return void
     */
    function assign($variable, $value)
    {
        $this->variables[$variable] = $value;
    } // function assign($variable, $value)


    /**
     * Check if template file exists
     * @access private
     * @param string template name
     * @return boolean
     */
    private function _template_exists($template)
    {
        return (@file_exists($template) && is_file($template));
    } // private function _template_exists($template)


    /**
     * Make and show template
     * @access private
     * @param string template name
     * @param integer http code
     * @return void
     */
    private function _print_template($template, $code = 200)
    {
        foreach($this->variables as $variable => $value)
        {
            $$variable = $value;
        }

        $this->_set_header_status_code($code);

        include_once($template);

        exit();
    }


    /**
     * Set the header status code
     * @access private
     * @param integer
     * @return void
     */
    private function _set_header_status_code($pnStatusCode)
    {
        $lstrStatusCode = (@isset($this->http_header_codes[$pnStatusCode])) ? $this->http_header_codes[$pnStatusCode] : '200 OK';

        header("HTTP/1.0 " . $lstrStatusCode);
    }
}

/* Location: /app/core/view.php */