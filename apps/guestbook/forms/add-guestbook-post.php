<?php

    session_start();

    $root = str_replace('apps/guestbook/forms', '', __DIR__);
    require_once $root.'constants.php';

    if (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] == 1) {
        $poster = $_POST['username'];
        $poster_id = $_SESSION['user_id'];
        $human = true;
    } elseif (isset($_POST['guest_name'])) {
        $poster = $_POST['guest_name'];
        // Guests can use a display name, but all guest posts will be under one user ID
        $poster_id = 2;

        // TODO: Antispam (later)
        $antispam_id = $_POST['antispam_challenge'];
        $antispam_answer = $_POST['antispam_response'];
        // Check the correct answer for "antispam_id" here...
        // For now, we will allow any answer while testing
        $correct_answer = $antispam_answer;

        // ...and compare the guest answer to it
        if ($antispam_answer === $correct_answer) {
            // If they match, then the poster is most likely human
            $human = true;
        } else {
            $human = false;
        }
    } else {
        // User ended up here incorrectly
       header('HTTP/1.1 401 Unauthorized');
        echo 'Unauthorized';
        exit;
    }

    if ($human == false) {
        header('HTTP/1.1 400 Bad Request');
        $response['status'] = 'error';
        $response['message'] = 'Incorrect antispam answer';
        echo json_encode($response);
        exit;
    }

    $comment = $_POST['comment'];
    $posted = date('Y-m-d H:i:s');

    // Check for all data
    if (isset($poster) and isset($poster_id) and isset($comment)) {
        require_once $root.'api/classes/Database.php';
        $db = new Database();

        // Add the comment
        $db->connect();
        $statement = 'INSERT INTO guestbook VALUES(
            0,
            :poster_id,
            :poster,
            :comment,
            :posted
        )';
        $params = array(
            'poster_id' => $poster_id,
            'poster' => $poster,
            'comment' => $comment,
            'posted' => $posted,
        );
        $db->run($statement, $params);
        $db->close();

        // Response
        if ($db->querySuccessful() == true) {
            $response['status'] = 'success';
            $response['message'] = 'Comment added successfully';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Could not update DB';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Missing required data';
    }

    header('Content-type: application/json');
    echo json_encode($response);
