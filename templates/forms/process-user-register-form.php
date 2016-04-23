<?php

    session_start();

    // Because this runs from a subdir /root/templates/forms
    $root = str_replace('templates/forms', '', dirname(__FILE__));
    require_once $root.'constants.php';

    // Form fields
    $name = $_POST['registerName'];
    $username = $_POST['registerUsername'];
    $password1 = $_POST['registerPassword'];
    $password2 = $_POST['registerPasswordConfirm'];

    // Validate password
    if ($password1 === $password2) {
        $password_matches = true;
    } else {
        $password_matches = false;
        $response['status'] = 'error';
        $response['message'] = 'Passwords do not match';
        header('Content-type: application/json');
        echo json_encode($response);
        return;
    }

    // Then hash it for the DB:
    if ($password_matches) {
        require $root.'classes/PasswordStorage.php';
        $pwd = new PasswordStorage();
        $password_secure = $pwd->create_hash($password1);
    }

    // Process the photos
    $thumbnail_errors = 0;
    $image_errors = 0;
    $path_for_uploads = 'user_photos/';

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
            64
        );

        $caption = $name;
    }
    $date_of_photos = date('Y-m-d H:i:s');

    // Check that everything went OK
    if ($imageUploader->successfullyUploadedAll() == false) {
        $image_errors += 1;
    }
    if ($resizer->thumbnailStatus() == false) {
        $thumbnail_errors += 1;
    }

    $full = $image['filename'];
    $thumbnail = 'thumbnails/'.$image['filename'];

    if (isset($name) && isset($username) && $image_errors == 0 && $thumbnail_errors == 0) {
        require_once $root.'/api/classes/Database.php';

        $db = new Database();

        // Add new avatar to album "6" (User-uploaded avatars)
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
                'album_id' => 6,
                'date_taken' => $date_of_photos,
                'taken_by' => $user,
                'full' => $photo['full-image'],
                'thumbnail' => $photo['thumbnail'],
                'caption' => $caption,
            );
            $db->run($statement, $params);
        }
        if ($db->querySuccessful() == false) {
            $image_errors += 1;
        }
        $db->close();

        // And then add the user into "users"
        $db->connect();
        $statement = 'INSERT INTO users VALUES(
            0,
            :name,
            :username,
            :password,
            :access_level
        )';
        $params = array(
            'name' => $name,
            'username' => $username,
            'password' => $password_secure,
            'access_level' => 2, // 2 = Normal user
        );
        $db->run($statement, $params);
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
        $response['status'] = 'error';
        $response['message'] = 'Missing photo details!';
        if ($image_errors > 0) {
            $response['message'] .= ' Could not upload image.';
        }
        if ($thumbnail_errors > 0) {
            $response['message'] .= ' Could not create thumbnail image.';
        }
        if (isset($name) == false) {
            $response['message'] .= ' Did not receive display name.';
        }
        if (isset($username) == false) {
            $response['message'] .= ' Did not receive user name.';
        }
    }

    header('Content-type: application/json');
    echo json_encode($response);
