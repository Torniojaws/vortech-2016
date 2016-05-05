<?php

    session_start();

    $user = $_POST['loginUser'];
    $pass = $_POST['loginPass'];
    $logout = $_POST['userLogout'];

    // Because this runs from a subdir /root/templates/forms
    $root = str_replace('apps/main/forms', '', dirname(__FILE__));

    // Only process if the form was actually submitted
    if (strlen($user) > 0 && strlen($pass) > 0) {
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
        try {
            $password_is_correct = $pwd->verify_password($_POST['loginPass'], $original_password);
        } catch (Exception $ex) {
            // echo $ex;
        }
        if ($password_is_correct) {
            $_SESSION['user_logged'] = 1;
            $_SESSION['username'] = $result[0]['username'];
            $_SESSION['display_name'] = $result[0]['name'];
            $_SESSION['user_id'] = $result[0]['id'];
            $response['status'] = 'success';
            $response['message'] = 'Login OK';
        } else {
            // true deletes the old session
            session_regenerate_id(true);
            $response['status'] = 'error';
            $response['message'] = 'Login failed';
        }
    } else {
        // true deletes the old session
        session_regenerate_id(true);
        $response['status'] = 'error';
        $response['message'] = 'Incorrect login';
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
