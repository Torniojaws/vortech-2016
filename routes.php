<?php

    $uri = $_SERVER['REQUEST_URI'];

    $route_list = explode('/', $uri);
    foreach($route_list as $route) {
        if(trim($route) != "") {
             $routes[] = $route;
        }
    }

    // For displaying the pages
    $last_item = end($routes);
    if($last_item == "api") {
        include('./api/index.php');
    } else {
        $target = "./templates/" . $last_item . ".php";
        if(file_exists($target)) {
            require($target);
        } else {
            include('./templates/main.php');
        }
    }

?>
