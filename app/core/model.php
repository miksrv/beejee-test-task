<?php
/**
 * Test task for BeeJee
 * @author Mikhail
 * @link <miksoft.pro>
 */

namespace Core;

use Libraries\MySQL as MySQL;

/**
 * The base class of the model provides access to the database for the child.
 * Class Model
 * @package Core
 */
class Model
{
    /**
     * Reference to the class object 'mysql'
     * @var object
     */
    public $mysql;

    function __construct()
    {
        require DIR_CONFIG . 'mysql.php';

        $this->mysql = new MySQL($config);
    }
}

/* Location: /app/core/model.php */