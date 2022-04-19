<?php

spl_autoload_register(function ($className) {
    // className = a Controllers\Article
    // require = librari/controllers/Article.php

    $className = str_replace("\\", "/", $className);
    require_once("library/$className.php");
});
