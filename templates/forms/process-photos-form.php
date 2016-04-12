<?php

    session_start();

    // Because this runs from a subdir /root/templates/forms
    $root = str_replace('templates/forms', '', dirname(__FILE__));

    // If this is not 1, a new photo album will be created
    if ($_POST['use-existing'] == 1) {
        $use_existing_album = true;
        $existing_album_id = (int) $_POST['selected-album'];
    } else {
        $use_existing_album = false;
        $new_album_name = $_POST['name'];
        $new_album_description = $_POST['description'];
        if ($_POST['gallery-newalbum'] == 'yes') {
            $new_album_show_in_gallery = 1;
        } else {
            $new_album_show_in_gallery = 0;
        }
    }

    $path_for_uploads = $_POST['album-category'];
    $date_of_photos = $_POST['date'];
    $photographer = $_POST['taken-by'];

    // The pictures
    $photo_count = 0;
    $image_path = '/static/img/'.$path_for_uploads;
    $thumbnail_path = $image_path.'/thumbnails/';
    $store_in = $root.$image_path;
    foreach ($_FILES as $file => $details)
    {
        ++$photo_count;
        $tmp = $details['tmp_name'];
        $target = $details['name'];
        // TODO: Create a thumbnail
        try {
            if (move_uploaded_file($tmp, $store_in.'/'.$target)) {
                copy($store_in.'/'.$target, $root.$thumbnail_path.$target);
            }
        } catch (Exception $ex) {
            die($ex);
        }
        // Captions are added after upload
        $caption = null;
        $photos[] = array(
            'full-image' => $target,
            'thumbnail' => 'thumbnails/'.$target,
            'caption' => $caption,
        );
    }

    date_default_timezone_set('Europe/Helsinki');

    if ($_SESSION['authorized'] == 1 && isset($photo_count) && $photo_count > 0
        && isset($date_of_photos) && strlen($date_of_photos) > 0) {
        require_once $root.'/api/classes/Database.php';

        $db = new Database();

        foreach ($photos as $photo)
        {
            $db->connect();
            $statement = 'INSERT INTO photos VALUES(
                0,
                :album_id,
                :date_taken,
                :taken_by,
                :full,
                :thumbnail,
                :caption
            )';
            $params = array(
                'album_id' => $existing_album_id,
                'date_taken' => $date_of_photos,
                'taken_by' => $photographer,
                'full' => $photo['full-image'],
                'thumbnail' => $photo['thumbnail'],
                'caption' => $photo['caption'],
            );
            $db->run($statement, $params);
        }
        $db->close();

        // Create new photo album
        if($use_existing_album == false) {
            $db->connect();

            $statement = 'INSERT INTO photo_albums VALUES(
                0,
                :category_id,
                :album_name,
                :description,
                :show_in_gallery
            )';

            $params = array(
                'category_id' => $existing_album_id,
                'album_name' => $new_album_name,
                'description' => $new_album_description,
                'show_in_gallery' => $new_album_show_in_gallery,
            );
            $db->run($statement, $params);
            $db->close();
        }

        if ($db->querySuccessful()) {
            $response['status'] = 'success';
            $response['message'] = 'Photos added to DB';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to add photos to DB!';
        }
    } else {
        if (isset($_SESSION['authorized']) == false) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Missing photo details';
        }
    }

    header('Content-type: application/json');
    echo json_encode($response);
