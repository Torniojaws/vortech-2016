<?php

    session_start();

    // Because this runs from a subdir
    $root = str_replace('apps/videos/admin', '', dirname(__FILE__));
    require_once $root.'constants.php';

    // Form data
    $title = $_POST['title'];
    $url = $_POST['url'];
    $host = get_host($url);
    $duration = $_POST['duration'];
    $category_id = (int) $_POST['category'];

    // Thumbnail
    $thumbnail_path = 'videos/thumbnails/';
    $thumbnail_upload_path = $root.'/static/img/'.$thumbnail_path;
    foreach ($_FILES as $file => $details) {
        $tmp = $details['tmp_name'];
        $target = $details['name'];
        try {
            move_uploaded_file($tmp, $thumbnail_upload_path.$target);
        } catch (Exception $ex) {
            die($ex);
        }
    }
    $thumbnail = $thumbnail_path.$target;

    if ($_SESSION['authorized'] == 1 && isset($title) && isset($url)) {
        require_once $root.'/api/classes/Database.php';

        $db = new Database();

        // Add new video
        $db->connect();
        $statement = 'INSERT INTO videos VALUES(
            0,
            :title,
            :url,
            :host,
            :duration,
            :thumbnail,
            :category_id
        )';
        $params = array(
            'title' => $title,
            'url' => $url,
            'host' => $host,
            'duration' => $duration,
            'thumbnail' => $thumbnail,
            'category_id' => $category_id,
        );
        $db->run($statement, $params);
        $db->close();

        if ($db->querySuccessful()) {
            $response['status'] = 'success';
            $response['message'] = 'Video added to DB';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to add video to DB!';
        }
    } else {
        if (isset($_SESSION['authorized']) == false) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Missing video details';
        }
    }

    /**
     * Get the host of a video from the url.
     *
     * @param $url The address of the video
     *
     * @return $host The host of the video
     */
    function get_host($url)
    {
        $parsed = parse_url($url);
        $host = str_replace('.com', '', $parsed['host']);
        $host = str_replace('www.', '', $host);
        $host = ucfirst($host);

        return $host;
    }

    header('Content-type: application/json');
    echo json_encode($response);
