<?php
/**
 * Test task for BeeJee
 * @author Mikhail
 * @link <miksoft.pro>
 */

namespace Models;

/**
 * Class Task
 * @package Models
 */
class Task extends \Core\Model {

    /**
     * Return tasks count
     * @return mixed|string
     * @throws \Exception
     */
    function getCount()
    {
        $_query = $this->mysql->query('SELECT COUNT(`task_id`) as count FROM tasks');
        $_data  = mysqli_fetch_assoc($_query);

        return $_data['count'];
    }


    /**
     * Return task data
     * @param $offset
     * @param $limit
     * @param string $sort
     * @param string $order
     * @return array|null
     * @throws \Exception
     */
    function get($offset, $limit, $sort = 'date', $order = 'desc')
    {
        if ( ! is_int($offset) || $offset <= 0)
        {
            $offset = 1;
        }

        $availableOrder = [
            'desc' => 'DESC',
            'asc'  => 'ASC'
        ];
        $availableSort = [
            'date'   => 'task_timestamp',
            'name'   => 'task_name',
            'email'  => 'task_email',
            'text'   => 'task_text',
            'status' => 'task_status'
        ];

        $offset = $offset * $limit - $limit;
        $_data  = $this->mysql->query('SELECT * FROM tasks ORDER BY `' . $availableSort[$sort] . '` ' . $availableOrder[$order] . ' LIMIT ' . $offset . ', ' . $limit);

        if ( ! mysqli_num_rows($_data))
        {
            return null;
        }

        $result = [];

        while ($tmp = mysqli_fetch_assoc($_data)) {
            $result[] = $tmp;
        }

        return $result;
    }


    /**
     * Return task data by ID
     * @param $taskID
     * @return bool|string[]|null
     * @throws \Exception
     */
    function getByID($taskID)
    {
        $_data  = $this->mysql->query("SELECT * FROM tasks WHERE `task_id` = '{$taskID}' LIMIT 1");

        if ( ! mysqli_num_rows($_data))
        {
            return false;
        }

        return mysqli_fetch_assoc($_data);
    }


    /**
     * Save task data by ID
     * @param $taskID
     * @param $data
     * @return bool
     */
    function save($taskID, $data)
    {
        return $this->mysql->save('tasks', [
            'data' => $data,
            'where' => [
                'task_id' => $taskID
            ]
        ]);
    }

    /**
     * Create new task
     * @param $data
     * @return bool
     */
    function create($data)
    {
        $data['task_id'] = uniqid();

        return $this->mysql->save('tasks', ['data' => $data]);
    }
}

/* Location: /app/models/task.php */