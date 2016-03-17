<?php

    /*
        For the full root, which changes depending on deployment environment,
        but is used as a constant in practice. Eg.
        http://localhost:5656/news
            or
        http://localhost/project/path/news
     */
    $root = $_SERVER['SERVER_NAME'];
    $port = $_SERVER['SERVER_PORT'];
    $root = $root . ":" . $port; // It is probably fine to use localhost:80 also
    $relative = $_SERVER['SCRIPT_NAME'];
    $relative = str_replace('index.php', '', $relative);
    $fullroot = $root . $relative;

    // Constants for the site
    define('ROOT_DIR', $fullroot);

?>
