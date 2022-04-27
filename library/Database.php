<?php

class Database
{
    // singleton sur $instance pour la connexion
    private static $instance = null;



    public static function getPdo(): PDO
    {
        @include_once "./library/connection.php";

        return self::$instance;
    }
}
