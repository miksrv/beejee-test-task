<?php
/**
 * Test task for BeeJee
 * @author Mikhail
 * @link <miksoft.pro>
 */

namespace Controllers;

use Core\Router as Router;
use Models\User as User;

/**
 * Login page controller
 * Class Index
 * @package Controllers
 */
class Login {

    /**
     * Link to the parent object (global object 'this')
     * @var object
     */
    private $parent;

    /**
     * Class Model Pointer
     * @var null
     */
    protected $userModel = null;

    /**
     * Current auth user data
     * @var null
     */
    protected $userData = null;

    function __construct($parent)
    {
        $this->parent    = $parent;
        $this->userModel = new User();
        $this->userData  = $this->userModel->check_session(filter_var($_SESSION['auth'],FILTER_SANITIZE_STRING));
    }


    /**
     * This method creates login page
     * @return void
     */
    function make()
    {
        if ( ! empty($this->userData)) {
            Router::redirect('/');
        }
    }

    /**
     * Ajax auth user handler - create user session and update in DB
     * @return mixed
     * @throws \Exception
     */
    function auth()
    {
        if ( ! empty($this->userData)) {
            Router::redirect('/');
        }

        if ( ! Router::is_ajax())
        {
            $this->parent->view->show_error_404();
        }

        $data = [
            'username' => filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING),
            'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_EMAIL),
        ];

        if ( ! $data['username'] || ! $data['password'])
        {
            return $this->parent->view->json([
                'status' => false,
                'error'  => 'Not all fields are filled out correctly'
            ]);
        }

        $user_data = $this->userModel->exists($data['username'], md5($data['password']));

        if ( ! $user_data)
        {
            return $this->parent->view->json([
                'status' => false,
                'error'  => 'Incorrect login or password'
            ]);
        }

        $_SESSION['auth'] = md5($user_data['user_id'] . $user_data['user_password'] . time());

        $this->userModel->set_session(
            $user_data['user_id'],
            $_SESSION['auth']
        );

        return $this->parent->view->json(['status' => true]);
    }


    /**
     * Clear user session data
     */
    function logout()
    {
        if (empty($this->userData)) {
            Router::redirect('/login');
        }

        $_SESSION['auth'] = '';

        $this->userModel->set_session(
            $this->userData['user_id'],
            ''
        );

        return Router::redirect('/');
    }
}

/* Location: /app/controllers/login.php */