<?php

    session_start();

    // Because this runs from a subdir /root/templates/forms
    $root = str_replace('templates/forms', '', dirname(__FILE__));
    require_once $root.'constants.php';

    // Mandatory fields
    $name = $_POST['name'];
    $type = $_POST['member-type'];
    $instrument = $_POST['instrument'];
    $started = $_POST['started'];
    $quit = $_POST['quit'];

    // When quit is empty, the member is an active member which
    // is indicated with a quit date of 9999-12-31 in the DB
    if (isset($quit) == false or empty($quit)) {
        $quit = '9999-12-31 23:59:59';
    }

    $thumbnail_errors = 0;
    $image_errors = 0;

    // A photo can be uploaded
    require_once $root.'classes/ImageUploader.php';
    $absolute_upload_path = $root.IMAGE_DIR.'band_members/';

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

    // The uploaded photo details must be POSTed to the "photos" table also
    if ($image_errors == 0 and $thumbnail_errors == 0) {
        $album = 6; // 6 = Band memmbers
        $date = date('Y-m-d H:i:s');
        $taken_by = 'Juha';

        $photo_api = 'api/v1/photos/add';
        $photo_request_api = SERVER_URL.$photo_api;

        // Generate the POST request
        $data = array(
            'album_id' => $album,
            'date' => $date,
            'taken_by' => $taken_by,
            'full' => $full,
            'thumbnail' => $thumbnail,
            'caption' => $name,
        );
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($photo_request_api, false, $context);
        if ($result === false) {
            $photo_response['status'] = 'error';
            $photo_response['message'] = 'Could not update photo details to DB';
        } else {
            $photo_response['status'] = 'success';
            $photo_response['message'] = 'Updated photo details to DB successfully';
        }
    }

    // For adding a member picture, we need the ID of the newly uploaded picture
    $newphoto_api = 'api/v1/photos/band-members/newest';
    $newphoto_list = file_get_contents(SERVER_URL.$newphoto_api);
    $newphoto_details = json_decode($newphoto_list, true);
    $photo_id = $newphoto_details[0]['id'];

    // Add to Members
    if ($_SESSION['authorized'] == 1 && isset($name) && isset($instrument) && isset($started) && isset($photo_id)
        && isset($type) && $image_errors == 0 && $thumbnail_errors == 0) {
        require_once $root.'/api/classes/Database.php';

        $db = new Database();

        $db->connect();
        $statement = 'INSERT INTO performers VALUES(
            0,
            :name,
            :type,
            :instrument,
            :started,
            :quit,
            :photo_id
        )';
        $params = array(
            'name' => $name,
            'type' => $type,
            'instrument' => $instrument,
            'started' => $started,
            'quit' => $quit,
            'photo_id' => $photo_id,
        );
        $db->run($statement, $params);
        $db->close();

        if ($db->querySuccessful() && $image_errors == 0 && $thumbnail_errors == 0) {
            $response['status'] = 'success';
            $response['message'] = 'Member added to DB';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to add member to DB!';
            if ($image_errors > 0) {
                $response['message'] .= ' Image upload failed.';
            }
            if ($thumbnail_errors > 0) {
                $response['message'] .= ' Thumbnail creation failed.';
            }
        }
    } else {
        if (isset($_SESSION['authorized']) == false) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        } elseif ($image_errors > 0 or $thumbnail_errors > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Failed to add to DB!';
            if ($image_errors > 0) {
                $response['message'] .= ' Image upload failed.';
            }
            if ($thumbnail_errors > 0) {
                $response['message'] .= ' Thumbnail creation failed.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Could not add member details';
        }
    }

    header('Content-type: application/json');
    echo json_encode($response);
