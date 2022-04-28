<?php

class Database
{
    // singleton sur $instance pour la connexion
    private static $instance = null;



    public static function getPdo(): PDO
    {
        //Il est en commentaire car la véritable connection pour mon site en ligne ce trouve dans ce dossier
        // et je le met dans le gitignore pour ne pas qu'il sois prit sur github
        // cela protege ma BDD
        //@include_once "./library/connection.php";

        $dbHost = "localhost";
        $dbName = "SMMediaBdd";
        $dbUser = "sebastien";
        $dbPwd = "sebastien";

        //connection de la BDD
        if (self::$instance === null) {
            self::$instance = $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", "$dbUser", "$dbPwd", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }


        return self::$instance;
    }
}
