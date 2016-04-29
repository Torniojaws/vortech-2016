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

        // We'll get the user's details
        $statement = 'SELECT * FROM users WHERE username = :user LIMIT 1';
        $params = array('user' => $user);
        $result = $db->run($statement, $params);
        $db->close();

        // Check that the user has admin rights
        if ($result[0]['access_level_id'] != 1) {
            header('HTTP/1.1 401 Unauthorized');
            $response['status'] = 'error';
            $response['message'] = 'Unauthorized';
            echo json_encode($response);

            return;
        }

        // And then see if the hashed DB password natches to user input:
        $original_password = $result[0]['password'];
        require $root.'classes/PasswordStorage.php';
        $pwd = new PasswordStorage();
        $password_is_correct = $pwd->verify_password($_POST['adPass'], $original_password);

        if ($password_is_correct) {
            $_SESSION['authorized'] = 1;
            $_SESSION['display_name'] = $result[0]['name'];
            $_SESSION['username'] = $result[0]['username'];
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
