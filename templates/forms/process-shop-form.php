<?php

    session_start();

    // Because this runs from a subdir /root/templates/forms
    $root = str_replace('templates/forms', '', dirname(__FILE__));
    require_once $root.'constants.php';

    // Form data
    $shop_category = $_POST['shop-category'];
    $product_name = $_POST['name'];
    $description = $_POST['description'];
    $price = (float) $_POST['price'];
    $paypal_button = $_POST['pp-button'];
    $paypal = $_POST['paypal'];
    $bandcamp = $_POST['bandcamp'];
    $amazon = $_POST['amazon'];
    $spotify = $_POST['spotify'];
    $deezer = $_POST['deezer'];
    $itunes = $_POST['itunes'];

    // If the item is a CD or Digital Album
    if (isset($_POST['selected-album'])) {
        // It will NOT contain an uploaded thumbnail - We'll use the release photo instead
        $release_code = $_POST['selected-album'];

        // We'll link to the photo of the release
        $release_api = 'api/v1/releases/'.$release_code;
        $release_details = file_get_contents(SERVER_URL.$release_api);
        $release = json_decode($release_details, true);
        $thumbnail = $release['thumbnail'];
    } else {
        // Other types of shop items can/should have a thumbnail uploaded
        $thumbnail_path = 'merch/thumbnails/';
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
    }



    if ($_SESSION['authorized'] == 1 && isset($photo_count) && $photo_count > 0
        && isset($date_of_photos) && strlen($date_of_photos) > 0) {
        require_once $root.'/api/classes/Database.php';

        $db = new Database();

        // Create new photo album
        if ($use_existing_album == false) {
            $db->connect();

            $statement = 'INSERT INTO photo_albums VALUES(
                0,
                :category_id,
                :album_name,
                :description,
                :show_in_gallery
            )';

            $params = array(
                'category_id' => $new_album_category_id,
                'album_name' => $new_album_name,
                'description' => $new_album_description,
                'show_in_gallery' => $new_album_show_in_gallery,
            );
            $db->run($statement, $params);
            $db->close();
        }

        // Get the ID of the new album
        if ($use_existing_album == false) {
            $db->connect();

            $statement = 'SELECT id
                          FROM photo_albums
                          WHERE name = :new_album_name';
            $params = array(
                'new_album_name' => $new_album_name,
            );
            $result = $db->run($statement, $params);
            $album_id = (int) $result[0]['id'];
            $db->close();
        }

        // Add new photos
        foreach ($photos as $photo) {
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
                'album_id' => $album_id,
                'date_taken' => $date_of_photos,
                'taken_by' => $photographer,
                'full' => $photo['full-image'],
                'thumbnail' => $photo['thumbnail'],
                'caption' => $photo['caption'],
            );
            $db->run($statement, $params);
        }
        $db->close();

        if ($db->querySuccessful() and $thumbnail_errors == 0) {
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
