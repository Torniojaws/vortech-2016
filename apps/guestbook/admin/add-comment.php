<?php

    $root = str_replace('apps/guestbook/admin', '', __DIR__);
    require_once $root.'classes/AddGuestbookComment.php';

    $data['id'] = $_POST['original_id'];
    $data['comment'] = $_POST['text'];
    $data['root'] = $root;

    // Process the data
    $addData = new AddGuestbookComment($data);
    $response = $addData->commit();

    header('Content-type: application/json');
    echo json_encode($response);
