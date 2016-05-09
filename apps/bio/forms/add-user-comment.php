<?php

    session_start();

    if (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] == 1) {
        // Mandatory information
        $member_id = $_POST['performer_id'];
        $modal_id = $_POST['modal_id'];
        $comment_subid = $_POST['comment_subid'];
        $comment = $_POST['comment'];
        $author_id = $_POST['user_id'];
        $author_Name = $_POST['username'];
        $posted = date('Y-m-d H:i:s');

        // Check for all data
        if (isset($member_id) and isset($comment_subid) and isset($comment)
            and isset($author_id) and isset($author_Name)) {

            $root = str_replace('apps/bio/forms', '', __DIR__);
            require_once $root.'api/classes/Database.php';
            $db = new Database();

            // Add the comment
            $db->connect();
            $statement = 'INSERT INTO performer_comments VALUES(
                0,
                :performer_id,
                :comment_subid,
                :username,
                :user_id,
                :comment,
                :posted
            )';
            $params = array(
                'performer_id' => $member_id,
                'comment_subid' => $comment_subid,
                'username' => $author_Name,
                'user_id' => $author_id,
                'comment' => $comment,
                'posted' => $posted,
            );
            $db->run($statement, $params);
            $db->close();

            // Response
            if ($db->querySuccessful() == true) {
                $response['status'] = 'success';
                $response['message'] = 'Comment added successfully';
                $response['modal_id'] = $modal_id; // Used to reload the Modal and show correct status div
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Could not update DB';
                $response['modal_id'] = $modal_id; // Used to reload the Modal and show correct status div
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Missing required data';
            $response['modal_id'] = $modal_id; // Used to reload the Modal and show correct status div
        }
    } else {
        header('HTTP/1.1 401 Unauthorized');
        echo 'Unauthorized';
        exit;
    }

    header('Content-type: application/json');
    echo json_encode($response);
