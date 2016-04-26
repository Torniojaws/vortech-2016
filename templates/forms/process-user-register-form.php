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

    // Create the user account
    require_once $root.'classes/RegisterUser.php';
    $userReg = new RegisterUser($root);
    if ($userReg->register($name, $username, $password1, $password2)) {
        $reg_status = true;
    } else {
        $reg_status = false;
    }

    // Add the details to DB
    if ($reg_status == true) {
        require_once $root.'api/classes/Database.php';
        $db = new Database();

        if ($userReg->imageWasUploaded() == true) {
            // Add new avatar to album "6" (User-uploaded avatars)
            foreach ($userReg->getUploadedImages() as $photo) {
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
                    'date_taken' => $userReg->getPhotoDate(),
                    'taken_by' => $name,
                    'full' => $userReg->getFullImageFilename(),
                    'thumbnail' => $userReg->getThumbnailFilename(),
                    'caption' => $name,
                );
                if ($params['date_taken'] == null or $params['taken_by'] == null or $params['full'] == null
                    or $params['thumbnail'] == null or $params['caption'] == null) {
                    $image_errors += 1;
                }
                $db->run($statement, $params);
            }
            if ($db->querySuccessful() == false) {
                $image_errors += 1;
            }
            $db->close();
        }

        // And then add the user into "users"
        $db->connect();
        $statement = 'INSERT INTO users VALUES(
            0,
            :name,
            :username,
            :password,
            :access_level,
            :caption
        )';
        $params = array(
            'name' => $name,
            'username' => $username,
            'password' => $userReg->getHashedPassword(),
            'access_level' => 2, // 2 = Normal user
            'caption' => 'User caption (you can update this through profile)',
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
        $response['message'] = 'Could not create user account!';
        if (isset($name) == false) {
            $response['message'] .= ' Did not receive display name.';
        }
        if (isset($username) == false) {
            $response['message'] .= ' Did not receive user name.';
        }
    }

    header('Content-type: application/json');
    echo json_encode($response);
