<?php

    session_start();

    if (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] == 1) {
        // Mandatory information
        $comment_subid = $_POST['comment_subid'];
        $release_code = $_POST['release_code'];
        $author = $_POST['display_name'];
        $author_id = $_POST['user_id'];
        $comment = $_POST['comment'];
        $posted = date('Y-m-d H:i:s');

        // Check for all data
        if (isset($comment_subid) and isset($release_code) and isset($author) and isset($author_id)
            and isset($comment)) {

            $root = str_replace('apps/releases/forms', '', __DIR__);
            require_once $root.'api/classes/Database.php';
            $db = new Database();

            // Add the comment
            $db->connect();
            $statement = 'INSERT INTO release_comments VALUES(
                0,
                :subid,
                :release_code,
                :author,
                :comment,
                :posted,
                :author_id
            )';
            $params = array(
                'subid' => $comment_subid,
                'release_code' => $release_code,
                'author' => $author,
                'comment' => $comment,
                'posted' => $posted,
                'author_id' => $author_id,
            );
            $db->run($statement, $params);
            $db->close();

            // Response
            if ($db->querySuccessful() == true) {
                $response['status'] = 'success';
                $response['message'] = 'Comment added successfully';
                $response['news_id'] = $release_code; // Used to show correct status div
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Could not update DB';
                $response['news_id'] = $release_code; // Used to show correct status div
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Missing required data';
            $response['news_id'] = $release_code; // Used to show correct status div
        }
    } else {
        header('HTTP/1.1 401 Unauthorized');
        echo 'Unauthorized';
        exit;
    }

    header('Content-type: application/json');
    echo json_encode($response);
