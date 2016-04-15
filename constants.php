<?php

    // Choose between "prod" and "dev"
    define('ENVIRONMENT', 'dev');

    // General settings
    date_default_timezone_set('Europe/Helsinki');
    define('MAX_UPLOAD_SIZE', 5242880); // 5 MB
    define('IMAGE_DIR', SERVER_URL.'static/img/');

    // Development settings
    if (ENVIRONMENT == 'dev') {
        // Session expires in 8 hours (28800 seconds)
        ini_set('session.gc_maxlifetime', 28800);
        session_set_cookie_params(28800);

        // Use this if Vagrant is setup to redirect 5656 to port 5656 in guest
        define('SERVER_URL', 'http://localhost:5656/');
        // Use this if Vagrant is setup to redirect 5656 to port 80 in guest
        #define('SERVER_URL', "http://localhost/");
    }

    // Production settings
    if (ENVIRONMENT == 'prod') {
        define('SERVER_URL', 'http://www.vortechmusic.com/');
    }
