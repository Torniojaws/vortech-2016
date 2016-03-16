<?php

    $uri = $_SERVER['REQUEST_URI'];

    $route_list = explode('/', $uri);
    foreach($route_list as $route) {
        if(trim($route) != "") {
             $routes[] = $route;
        }
    }

    // For displaying the pages
    if($routes[0] == "api") {
        include('api/index.php');
    } else {
        $target = "templates/" . $routes[0] . ".php";
        if(file_exists($target)) {
            include($target);
        } else {
            include("templates/main.php");
        }
    }

?>
