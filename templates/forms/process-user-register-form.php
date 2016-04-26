<?php

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
        require $root.'classes/PasswordStorage.php';
        $pwd = new PasswordStorage();
        $password_secure = $pwd->create_hash($_POST['registerPassword']);
        $password_ok = true;
    }

    // User avatar and thumbnail
    if (isset($_FILES['photo']) == true and $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
        $user_uploaded_image = true;

        $path_for_uploads = 'user_photos/';
        $absolute_upload_path = $root.IMAGE_DIR.$path_for_uploads;

        // Upload original
        require_once $root.'classes/ImageUploader.php';
        $imageUploader = new ImageUploader($root, $absolute_upload_path);
        $imageUploader->processUploadedImages();
        $uploads = $imageUploader->getAssocArrayOfUploadedImages();
        if ($uploads == null) {
            $images_ok = false;
        } else {
            $images_ok = true;
        }

        // Create thumbnail
        require_once $root.'classes/ImageResizer.php';
        $resizer = new ImageResizer();
        foreach ($uploads as $image) {
            $resizer->createThumbnail(
                $image['fullpath'].$image['filename'],
                $absolute_upload_path.'thumbnails/',
                $image['filename'],
                64
            );
            if ($resizer->thumbnailStatus() == true) {
                $full_image = $image['filename'];
                $thumbnail = 'thumbnails/'.$image['filename'];
            } else {
                $images_ok = false;
            }
        }
    } else {
        $user_uploaded_image = false;
        $images_ok = true;
    }

    // Add the details to DB
    if ($password_ok == true and $images_ok == true) {
        require_once $root.'api/classes/Database.php';
        $db = new Database();

        if ($user_uploaded_image == true) {
            // Add new avatar to album "6" (User-uploaded avatars)
            foreach ($uploads as $photo) {
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
                    'date_taken' => date('Y-m-d H:i:s'),
                    'taken_by' => $name,
                    'full' => $full_image,
                    'thumbnail' => $thumbnail,
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
            'password' => $password_secure,
            'access_level' => 2, // 2 = Normal user
            'caption' => 'User caption (you can edit this through your profile)',
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
