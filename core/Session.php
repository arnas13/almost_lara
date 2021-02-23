<?php 

namespace app\core;

class Session {
    public function __construct()
    {
        session_start();
    }

    /**
     * Checks if user is logged in
     *
     * @return boolean
     */
    public static function isUserLoggedIn(): bool {
        if(isset($_SESSION['user_id'])) return true;

        return false;
    }
}