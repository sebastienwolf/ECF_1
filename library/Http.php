<?php

class Http
{

    // redirect (index.php)
    public static function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }
}
