<?php

    // Constants for the site

    # Use this if Vagrant is setup to redirect 5656 to port 5656 in guest
    #define('SERVER_URL', 'http://localhost:5656/');

    # Use this if Vagrant is setup to redirect 5656 to port 80 in guest
    #define('SERVER_URL', "http://localhost/");

    # Testing if this is portable
    $url = 'http://'.$_SERVER['SERVER_NAME'].'/';
    define('SERVER_URL', $url);

    # This is the base url in production
    #define('SERVER_URL', 'http://www.vortechmusic.com');
