<?php
    //gg
    require_once "app/config/autoloader.php"; //importo il file per fare l'autoloading grazie ai namespace
    require_once "app/config/db_config.php";
    require_once "app/config/database.php";
    //require_once "app\controller\dispatcher\dispatcher.php";

    use app\controller\dispatcher;

    $dispatcher = new dispatcher(); //si crea il dispacher

    $dispatcher -> handle(); //legge l'url e manda al controller che esegue una view
