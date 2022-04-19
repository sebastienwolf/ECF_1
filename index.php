<?php
session_start();
require_once('library/autoload.php');

\Application::process();
// $controller = new \Controllers\Article();
// $controller->index();