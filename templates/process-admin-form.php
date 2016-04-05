<?php

    session_start();

    $user = $_POST['adUser'];
    $pass = $_POST['adPass'];

    // Only process if the form was actually submitted
    if (isset($user) && isset($pass)) {
        // Because this runs from a subdir
        $root = str_replace('templates', '', dirname(__FILE__));
        require_once($root.'/api/classes/database.php');
        $db = new Database();
        $db->connect();

        // TODO: security (long random salt and encryption)
        // https://crackstation.net/hashing-security.htm#normalhashing
        $statement = "SELECT * FROM users WHERE username = :user AND password :pass LIMIT 1";
        $params = array('user' => $user, 'pass' => $pass);
        $result = $db->run($statement, $params);

        if ($result != null) {
            $_SESSION['authorized'] = 1;
        }
        echo 'jee';
    } else {
        echo 'Crap';
    }
