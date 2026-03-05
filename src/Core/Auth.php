<?php
namespace App\Core;

class Auth
{
    
    public static function user()
    {
        return $_SESSION['user_name'] ?? null;
    }

    public static function logout()
    {
        session_destroy();
    }
}