<?php

    $root = str_replace('apps/videos/admin', '', __DIR__);
    require_once $root.'classes/AddVideo.php';

    // data
    $data['root'] = $root;
    $data['title'] = $_POST['title'];
    $data['url'] = $_POST['url'];
    $data['duration'] = $_POST['duration'];
    $data['category'] = (int) $_POST['category'];
    // Video thumbnail
    $data['thumbnail'] = $_FILES;

    // Process the data
    $addData = new AddVideo($data);
    $response = $addData->commit();

    header('Content-type: application/json');
    echo json_encode($response);
