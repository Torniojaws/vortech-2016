<?php

    session_start();

    // Mandatory fields
    // Only ONE comment is allowed per guestbook post ID - but an admin can edit his comment
    $post_id = $_POST['original_id'];
    $admin_comment = $_POST['text'];

    date_default_timezone_set('Europe/Helsinki');
    $posted = date('Y-m-d H:i:s');

    // Because this runs from a subdir "apps/guestbook/forms/"
    $root = str_replace('apps/guestbook/admin', '', dirname(__FILE__));

    if ($_SESSION['authorized'] == 1 && isset($post_id) && isset($admin_comment)) {
        require_once $root.'/api/classes/Database.php';

        $db = new Database();
        $db->connect();

        $statement = 'INSERT INTO guestbook_comments VALUES(
            0,
            :post_id,
            1,
            :comment,
            :posted
        )';
        $params = array(
            'post_id' => $post_id,
            'comment' => $admin_comment,
            'posted' => $posted,
        );
        $db->run($statement, $params);
        $db->close();

        if ($db->querySuccessful()) {
            $response['status'] = 'success';
            $response['message'] = 'Comment added to DB';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to add comment to DB! Trying twice?';
        }
    } else {
        if (isset($_SESSION['authorized']) == false) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Missing required data';
        }
    }

    header('Content-type: application/json');
    echo json_encode($response);
