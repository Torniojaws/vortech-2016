<?php

    session_start();

    // Mandatory fields
    $title = $_POST['title'];
    $text = $_POST['text'];
    $tags = $_POST['tags']; // Comma separated

    date_default_timezone_set('Europe/Helsinki');
    $posted = date('Y-m-d H:i:s');

    // Tags are a comma separated list, which will be formatted in a standard way
    // eg. "tag, another tag, third tag"
    if (isset($tags)) {
        // Remove empty items and extraneous white spaces
        $tags = array_filter(explode(',', $tags), 'strlen');
        $tags = array_map('trim', $tags);
        $processed_tags = implode(', ', $tags);
    }

    // Because this runs from a subdir /root/templates/forms
    $root = str_replace('apps/news/admin', '', dirname(__FILE__));

    if ($_SESSION['authorized'] == 1 && isset($title) && isset($text)) {
        require_once $root.'/api/classes/Database.php';

        $db = new Database();
        $db->connect();

        $statement = 'INSERT INTO news VALUES(
            0,
            :title,
            :newstext,
            :posted,
            :author,
            :tags
        )';
        $params = array(
            'title' => $title,
            'newstext' => $text,
            'posted' => $posted,
            'author' => $_SESSION['username'],
            'tags' => $processed_tags,
        );
        $db->run($statement, $params);
        $db->close();

        if ($db->querySuccessful()) {
            $response['status'] = 'success';
            $response['message'] = 'News added to DB';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to add news to DB!';
        }
    } else {
        if (isset($_SESSION['authorized']) == false) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Missing news title or news text';
        }
    }

    header('Content-type: application/json');
    echo json_encode($response);
