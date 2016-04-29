<?php

    session_start();

    // Because this runs from a subdir /root/templates/forms
    $root = str_replace('templates/forms', '', dirname(__FILE__));
    require_once $root.'constants.php';

    // If this is not 1, a new photo album will be created
    if ($_POST['use-existing'] == 1) {
        $use_existing_album = true;
        $album_id = (int) $_POST['selected-album'];
    } else {
        $use_existing_album = false;
        $new_album_name = $_POST['name'];
        $new_album_description = $_POST['description'];
        if ($_POST['gallery-newalbum'] == 'yes') {
            $new_album_show_in_gallery = 1;
        } else {
            $new_album_show_in_gallery = 0;
        }
        $new_album_category_id = (int) $_POST['category-newalbum'];
    }

    $path_for_uploads = $_POST['album-category'].'/';
    $date_of_photos = $_POST['date'];
    $photographer = $_POST['taken-by'];

    // Process the photos
    $thumbnail_errors = 0;
    $image_errors = 0;

    require_once $root.'classes/ImageUploader.php';
    $absolute_upload_path = $root.IMAGE_DIR.$path_for_uploads;

    $imageUploader = new ImageUploader($root, $absolute_upload_path);
    $imageUploader->processUploadedImages();
    // Each array element contains info about one successfully uploaded image
    $uploads = $imageUploader->getAssocArrayOfUploadedImages();

    // Thumbnail creation
    require_once $root.'classes/ImageResizer.php';
    $resizer = new ImageResizer($root);

    foreach ($uploads as $image) {
        $resizer->createThumbnail(
            $image['fullpath'].$image['filename'],
            $absolute_upload_path.'thumbnails/',
            $image['filename'],
            200
        );

        // Captions are added after upload
        $caption = null;
        $photos[] = array(
            'full-image' => $image['filename'],
            'thumbnail' => 'thumbnails/'.$image['filename'],
            'caption' => $caption,
        );
    }

    // Check that everything went OK
    if ($imageUploader->successfullyUploadedAll() == false) {
        $image_errors += 1;
    }
    if ($resizer->thumbnailStatus() == false) {
        $thumbnail_errors += 1;
    }

    $full = $image['filename'];
    $thumbnail = 'thumbnails/'.$image['filename'];

    if ($_SESSION['authorized'] == 1 && isset($date_of_photos) && strlen($date_of_photos) > 0
        && $image_errors == 0 && $thumbnail_errors == 0) {
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

        if ($db->querySuccessful() and $thumbnail_errors == 0 and $image_errors == 0) {
            $response['status'] = 'success';
            $response['message'] = 'Photos added to DB';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to add photos to DB!';
            if ($thumbnail_errors > 0) {
                $response['message'] .= ' Could not create thumbnails';
            }
            if ($image_errors > 0) {
                $response['message'] .= ' Could not upload images';
            }
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
