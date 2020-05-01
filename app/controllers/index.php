<?php
/**
 * Test task for BeeJee
 * @author Mikhail
 * @link <miksoft.pro>
 */

namespace Controllers;

use Core\Router as Router;
use Models\Task as Task;
use Models\User as User;
use Libraries\Paginator as Paginator;

/**
 * Home page controller
 * Class Index
 * @package Controllers
 */
class Index {

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
     * Class Model Pointer
     * @var null
     */
    protected $taskModel = null;

    /**
     * Current auth user data
     * @var null
     */
    protected $userData = null;

    function __construct($parent)
    {
        $this->parent    = $parent;
        $this->taskModel = new Task();
        $this->userModel = new User();
        $this->userData  = $this->userModel->check_session(filter_var($_SESSION['auth'],FILTER_SANITIZE_STRING));
    }


    /**
     * This method creates the main page of task list
     * @return void
     */
    function make()
    {
        $itemPerPage = 2;
        $currentPage = (int) filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
        $totalItems  = $this->taskModel->getCount();

        $sortFilter = filter_input(INPUT_GET, 'sort', FILTER_SANITIZE_STRING);
        $sortOrder  = filter_input(INPUT_GET, 'order', FILTER_SANITIZE_STRING);
        $editTask   = filter_input(INPUT_GET, 'edit', FILTER_SANITIZE_STRING);

        if ($currentPage <= 0)
        {
            $currentPage = 1;
        }

        if ( ! in_array($sortFilter, ['date', 'name', 'email', 'text', 'status']))
        {
            $sortFilter = 'date';
        }

        if ( ! in_array($sortOrder, ['desc', 'asc']))
        {
            $sortOrder = 'desc';
        }

        $paginator  = new Paginator($totalItems, $itemPerPage, $currentPage, '/?page=(:num)&sort=' . $sortFilter . '&order=' . $sortOrder);

        if ( ! empty($this->userData) && $editTask)
        {
            $this->parent->view->assign('taskData', $this->taskModel->getByID($editTask));
        }

        $this->parent->view->assign('sort', $sortFilter);
        $this->parent->view->assign('order', $sortOrder);
        $this->parent->view->assign('paginator', $paginator);
        $this->parent->view->assign('page', $currentPage);
        $this->parent->view->assign('user', $this->userData);
        $this->parent->view->assign('tasks', $this->taskModel->get($currentPage, $itemPerPage, $sortFilter, $sortOrder));
    }

    /**
     * Ajax save task handler
     * @return mixed
     */
    function save()
    {
        if ( ! Router::is_ajax())
        {
            $this->parent->view->show_error_404();
        }

        $taskID = filter_input(INPUT_POST, 'task_id', FILTER_SANITIZE_STRING);
        $data   = [
            'task_name'  => filter_input(INPUT_POST, 'task_name', FILTER_SANITIZE_STRING),
            'task_email' => filter_input(INPUT_POST, 'task_email', FILTER_SANITIZE_EMAIL),
            'task_text'  => filter_input(INPUT_POST, 'task_text', FILTER_SANITIZE_STRING),
        ];

        if ( ! $data['task_name'] || ! $data['task_email'] || ! $data['task_text'])
        {
            return $this->parent->view->json([
                'status' => false,
                'error'  => 'Not all fields are filled out correctly'
            ]);
        }

        if ( ! empty($taskID) && ! empty($this->userData))
        {
            $data['task_status'] = filter_input(INPUT_POST, 'task_status', FILTER_SANITIZE_NUMBER_INT);
            $this->taskModel->save($taskID, $data);
        }
        else if ( ! empty($taskID) && empty($this->userData))
        {
            return $this->parent->view->json([
                'status' => false,
                'error'  => 'To edit a task, you must be logged in.'
            ]);
        }
        else
        {
            $this->taskModel->create($data);
        }

        return $this->parent->view->json(['status' => true]);
    }
}

/* Location: /app/controllers/index.php */