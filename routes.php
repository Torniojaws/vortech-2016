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

    /*
        Support for sub-URI like http://localhost/photos/live

        The first -1 is for 0-index conversion
        The second -1 is to get the second last item of the URI
    */
    $second_last = count($routes) - 1 - 1;
    $second_last_item = $routes[$second_last];

    // Build the target file path
    if($last_item == "api") {
        include('./api/index.php');
    } else {
        // Build the correct path
        if($second_last_item == 'photos') {
            $target = "./templates/photos-" . $last_item . ".php";
        } else {
            $target = "./templates/" . $last_item . ".php";
        }

        // Include the correct file
        if(file_exists($target)) {
            require($target);
        } else {
            include('./templates/main.php');
        }
    }

?>
