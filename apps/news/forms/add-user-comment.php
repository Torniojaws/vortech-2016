<?php

    session_start();

    if (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] == 1) {
        // Mandatory information
        $comment_subid = $_POST['comment_subid'];
        $news_id = $_POST['news_id'];
        $author = $_POST['display_name'];
        $author_id = $_POST['user_id'];
        $comment = $_POST['comment'];
        $posted = date('Y-m-d H:i:s');

        // Check for all data
        if (isset($comment_subid) and isset($news_id) and isset($author) and isset($author_id)
            and isset($comment)) {
            $root = str_replace('apps/news/forms', '', __DIR__);
            require_once $root.'api/classes/Database.php';
            $db = new Database();

            // Add the comment
            $db->connect();
            $statement = 'INSERT INTO news_comments VALUES(
                0,
                :subid,
                :news_id,
                :author,
                :comment,
                :posted,
                :author_id
            )';
            $params = array(
                'subid' => $comment_subid,
                'news_id' => $news_id,
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
                $response['news_id'] = $news_id; // Used to show correct status div
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Could not update DB';
                $response['news_id'] = $news_id; // Used to show correct status div
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Missing required data';
            $response['news_id'] = $news_id; // Used to show correct status div
        }
    } else {
        header('HTTP/1.1 401 Unauthorized');
        echo 'Unauthorized';
        exit;
    }

    header('Content-type: application/json');
    echo json_encode($response);
