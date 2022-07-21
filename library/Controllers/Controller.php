<?php

namespace Controllers;

abstract class Controller
{
    protected $model;
    protected $modelName;


    public function __construct()
    {
        $this->model = new $this->modelName();
    }

    public function checkAdmin()
    {
        if ($_SESSION['userType'] !== "admin") {
            header('Location: index.php?controller=article&task=index');
            die;
        }
    }
    public function checkUser()
    {
        if (!isset($_SESSION['userType'])) {
            header('Location: index.php?controller=article&task=index');
            die;
        }
    }

    public function checkSession()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }
}
