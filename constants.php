<?php

    // Constants for the site
    date_default_timezone_set('Europe/Helsinki');
    
    # Use this if Vagrant is setup to redirect 5656 to port 5656 in guest
    define('SERVER_URL', 'http://localhost:5656/');

    # Use this if Vagrant is setup to redirect 5656 to port 80 in guest
    #define('SERVER_URL', "http://localhost/");

    # This is the base url in production
    #define('SERVER_URL', 'http://www.vortechmusic.com/');
