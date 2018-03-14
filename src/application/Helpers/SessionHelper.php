<?php

namespace App\Helpers;

class SessionHelper
{
    /**
     * Function to create session
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    /**
     * Function to get session value
     * @param $key
     * @return null
     */
    public function get($key)
    {
        if($this->exists($key)) {
            return $_SESSION[$key];
        }
        return null;
    }

    /**
     * Function to check if session exists
     * @param $key
     * @return bool
     */
    public function exists($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Function to delete the session
     */
    public function delete()
    {
        return session_unset();
    }
}