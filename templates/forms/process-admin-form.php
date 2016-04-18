<?php

    session_start();

    $user = $_POST['adUser'];
    $pass = $_POST['adPass'];
    $logout = $_POST['adLogout'];

    // Because this runs from a subdir /root/templates/forms
    $root = str_replace('templates/forms', '', dirname(__FILE__));

    // Only process if the form was actually submitted
    if (isset($user) && isset($pass)) {
        require_once $root.'/api/classes/database.php';

        $db = new Database();
        $db->connect();

        // TODO: security (long random salt and encryption)
        // https://crackstation.net/hashing-security.htm#normalhashing
        $statement = 'SELECT * FROM users WHERE username = :user AND password = :pass LIMIT 1';
        $params = array('user' => $user, 'pass' => $pass);
        $result = $db->run($statement, $params);

        if ($result != null) {
            $_SESSION['authorized'] = 1;
            $_SESSION['username'] = $result[0]['name'];
            $response['status'] = 'success';
            $response['message'] = 'Login OK';
        } else {
            // true deletes the old session
            session_regenerate_id(true);
            $response['status'] = 'error';
            $response['message'] = 'Login failed';
        }
    }

    // Admin wants to logout
    if (isset($_SESSION['authorized']) && $_SESSION['authorized'] == 1 && isset($logout)) {
        require_once $root.'/classes/Admin.php';
        $admin = new Admin();
        $admin->logout();
        $response['status'] = 'success';
        $response['message'] = 'Logout OK';
    }

    header('Content-type: application/json');
    echo json_encode($response);
