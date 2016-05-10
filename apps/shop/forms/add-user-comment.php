<?php

    session_start();

    if (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] == 1) {
        // Mandatory information
        $shopitem_id = $_POST['shopitem_id'];
        $comment_subid = $_POST['comment_subid'];
        $category_comment_subid = $_POST['category_comment_subid'];
        $user_id = $_POST['user_id'];
        $comment = $_POST['comment'];
        $posted = date('Y-m-d H:i:s');

        // Check for all data
        if (isset($shopitem_id) and isset($comment_subid) and isset($category_comment_subid)
            and isset($user_id) and isset($comment)) {

            $root = str_replace('apps/shop/forms', '', __DIR__);
            require_once $root.'api/classes/Database.php';
            $db = new Database();

            // Add the comment
            $db->connect();
            $statement = 'INSERT INTO shopitem_comments VALUES(
                0,
                :shopitem_id,
                :comment_subid,
                :category_comment_subid,
                :comment,
                :user_id,
                :posted
            )';
            $params = array(
                'shopitem_id' => $shopitem_id,
                'comment_subid' => $comment_subid,
                'category_comment_subid' => $category_comment_subid,
                'comment' => $comment,
                'user_id' => $user_id,
                'posted' => $posted,
            );
            $db->run($statement, $params);
            $db->close();

            // Response
            if ($db->querySuccessful() == true) {
                $response['status'] = 'success';
                $response['message'] = 'Comment added successfully';
                $response['modal_id'] = $shopitem_id; // Used to show correct status div
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Could not update DB';
                $response['modal_id'] = $shopitem_id; // Used to show correct status div
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Missing required data';
            $response['modal_id'] = $shopitem_id; // Used to show correct status div
        }
    } else {
        header('HTTP/1.1 401 Unauthorized');
        echo 'Unauthorized';
        exit;
    }

    header('Content-type: application/json');
    echo json_encode($response);
