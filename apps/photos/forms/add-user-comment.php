<?php

    session_start();

    if (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] == 1) {
        // Mandatory information
        $photo_id = $_POST['photo_id'];
        $comment_subid = $_POST['comment_subid'];
        $category_comment_subid = $_POST['category_comment_subid'];
        $comment = $_POST['comment'];
        $author_id = $_POST['user_id'];
        $posted = date('Y-m-d H:i:s');

        // Check for all data
        if (isset($comment_subid) and isset($photo_id) and isset($comment_subid) and isset($author_id)
            and isset($category_comment_subid)) {

            $root = str_replace('apps/photos/forms', '', __DIR__);
            require_once $root.'api/classes/Database.php';
            $db = new Database();

            // Add the comment
            $db->connect();
            $statement = 'INSERT INTO photo_comments VALUES(
                0,
                :photo_id,
                :comment_subid,
                :category_comment_subid,
                :comment,
                :author_id,
                :posted
            )';
            $params = array(
                'photo_id' => $photo_id,
                'comment_subid' => $comment_subid,
                'category_comment_subid' => $category_comment_subid,
                'comment' => $comment,
                'author_id' => $author_id,
                'posted' => $posted,
            );
            $db->run($statement, $params);
            $db->close();

            // Response
            if ($db->querySuccessful() == true) {
                $response['status'] = 'success';
                $response['message'] = 'Comment added successfully';
                $response['photo_id'] = $photo_id; // Used to reload the Modal and show correct status div
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Could not update DB';
                $response['photo_id'] = $photo_id; // Used to reload the Modal and show correct status div
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Missing required data';
            $response['photo_id'] = $photo_id; // Used to reload the Modal and show correct status div
        }
    } else {
        header('HTTP/1.1 401 Unauthorized');
        echo 'Unauthorized';
        exit;
    }

    header('Content-type: application/json');
    echo json_encode($response);
