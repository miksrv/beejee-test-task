<?php
/**
 * Test task for BeeJee
 * @author Mikhail
 * @link <miksoft.pro>
 */

namespace Libraries;

/**
 * MySQL database management class
 * Class MySQL
 * @package Libraries
 */
class MySQL
{
    /**
     * The ID of the resource connection to MySQL
     * @var integer
     */
    var $_source;

    /**
     * Connection status database
     * @var integer
     */
    var $_state = 0;

    function __construct($config)
    {
        $this->connect($config);
    }


    function __destruct()
    {
        $this->close();
    }


    /**
     * Create a database connection
     * @final
     * @access private
     * @return void
     */
    final private function connect($config)
    {
        if ( ! is_array($config) || empty($config))
        {
            throw new \Exception('Emtpy mysql configuration');
        }

        $this->_source = mysqli_connect($config['hostname'], $config['username'], $config['password']);
        $database_name = mysqli_select_db($this->_source, $config['database']);

        mysqli_query($this->_source, "SET NAMES 'utf8'");
        mysqli_query($this->_source, "SET CHARACTER SET 'utf8'");

        if ( ! $this->_source)
        {
            throw new \Exception('Can not connect to MySQL');
        }
        else if ( ! $database_name)
        {
            throw new \Exception('You can not choose a MySQL database');
        }
        else
        {
            $this->_state = 1;
        }
    }


    /**
     * Closes a database connection
     * @final
     * @access private
     * @return void
     */
    final private function close()
    {
        if ($this->_source && $this->_state)
        {
            mysqli_close($this->_source);
            $this->_state = 0;
        }
    }


    /**
     * Query the database
     * @param string $sql
     * @return
     */
    function query($sql)
    {
        if ( ! $this->_state || ! $this->_source)
        {
            return ;
        }

        $result = mysqli_query($this->_source, $sql);

        if (mysqli_errno($this->_source))
        {
            throw new \Exception(mysqli_errno($this->_source) . ': ' . mysqli_error($this->_source) . '<br />' . $sql);
        }

        return $result;
    }


    /**
     * Saves settings and inserts a new row in the database table
     * @param string table name
     * @param array conditions
     * @return boolean
     */
    function save($table, $params)
    {
        if ( ! isset($params['data']) || empty($params['data']) || ! is_array($params['data']))
        {
            return false;
        }

        if ( ! isset($params['where']) || empty($params['where']))
        {
            $count = count($params['data']);
            $keys  = $vals = " (";
            foreach ($params['data'] as $key => $val)
            {
                $sep = ( --$count ? ", " : ")");
                $keys .= "`{$key}`{$sep}";
                $vals .= "'{$val}'{$sep}";
            }

            $sql = "INSERT INTO {$table} {$keys} VALUES {$vals}";
        }
        else
        {
            $count = count($params['where']);
            $where = $data = '';
            foreach ($params['where'] as $key => $val)
            {
                $sep = ( --$count ? " AND " : "");
                $where .= "`{$key}` = '{$val}'{$sep}";
            }

            $count = count($params['data']);
            foreach ($params['data'] as $key => $val)
            {
                $sep = ( --$count ? ", " : " WHERE {$where}");
                $data .= "`{$key}` = '{$val}'{$sep}";
            }

            $sql = "UPDATE {$table} SET {$data}";
        }

        return $this->query($sql);
    }
}

/* Location: /app/libraries/mysql.php */