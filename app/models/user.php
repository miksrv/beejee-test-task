<?php
/**
 * Test task for BeeJee
 * @author Mikhail
 * @link <miksoft.pro>
 */

namespace Models;

/**
 * Class User
 * @package Models
 */
class User extends \Core\Model {

    /**
     * Return user data by login (name) and password hash
     * @param $login
     * @param $password
     * @return bool|string[]|null
     * @throws \Exception
     */
    function exists($login, $password)
    {
        $_data  = $this->mysql->query("SELECT * FROM users WHERE `user_name` = '{$login}' AND `user_password` = '{$password}' LIMIT 1");

        if ( ! mysqli_num_rows($_data))
        {
            return false;
        }

        $tmp = mysqli_fetch_assoc($_data);

        if (isset($tmp['user_id']) && ! empty($tmp['user_id']))
        {
            return $tmp;
        }

        return false;
    }

    /**
     * Set user session
     * @param $user_id
     * @param $session_id
     * @return bool
     */
    function set_session($user_id, $session_id)
    {
        return $this->mysql->save('users', [
            'data' => [
                'user_session' => $session_id
            ],
            'where' => [
                'user_id' => $user_id
            ]
        ]);
    }


    /**
     * Return user data by session ID
     * @param $session_id
     * @return bool|string[]|null
     * @throws \Exception
     */
    function check_session($session_id)
    {
        if (empty($session_id))
        {
            return false;
        }

        $_data  = $this->mysql->query("SELECT * FROM users WHERE `user_session` = '{$session_id}' LIMIT 1");

        if ( ! mysqli_num_rows($_data))
        {
            return false;
        }

        $tmp = mysqli_fetch_assoc($_data);

        if (isset($tmp['user_id']) && ! empty($tmp['user_id']))
        {
            return $tmp;
        }

        return false;
    }
}

/* Location: /app/models/user.php */