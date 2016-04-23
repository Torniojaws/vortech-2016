<?php

    session_start();

    $user = $_POST['loginUser'];
    $pass = $_POST['loginPass'];
    $logout = $_POST['userLogout'];

    // Because this runs from a subdir /root/templates/forms
    $root = str_replace('templates/forms', '', dirname(__FILE__));

    // Only process if the form was actually submitted
    if (isset($user) && isset($pass)) {
        require_once $root.'/api/classes/Database.php';

        $db = new Database();
        $db->connect();

        // We'll get the user's details
        $statement = 'SELECT * FROM users WHERE username = :user LIMIT 1';
        $params = array('user' => $user);
        $result = $db->run($statement, $params);

        // And then see if the hashed DB password natches to user input:
        $original_password = $result[0]['password'];
        require $root.'classes/PasswordStorage.php';
        $pwd = new PasswordStorage();
        $password_is_correct = $pwd->verify_password($_POST['loginPass'], $original_password);
        if ($password_is_correct) {
            $_SESSION['user_logged'] = 1;
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

    // User wants to logout
    if (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] == 1 && isset($logout)) {
        require_once $root.'/classes/User.php';
        $user = new User();
        $user->logout();
        $response['status'] = 'success';
        $response['message'] = 'Logout OK';
    }

    header('Content-type: application/json');
    echo json_encode($response);
