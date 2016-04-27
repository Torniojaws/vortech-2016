<?php

    session_start();
    require_once '../../constants.php';

    // Because this runs from a subdir
    $root = str_replace('templates/edits', '', dirname(__FILE__));

    if (isset($_SESSION) && $_SESSION['user_logged'] == 1 && isset($_POST)) {

        // Values from the form
        $display_name = $_POST['profileName'];
        $username = $_POST['profileUsername'];
        $caption = $_POST['profileCaption'];
        $old_password = $_POST['profileOldPassword'];
        $new_password1 = $_POST['profileNewPassword1'];
        $new_password2 = $_POST['profileNewPassword2'];

        // Password update
        require $root.'classes/PasswordStorage.php';
        $pwd = new PasswordStorage();

        // Check that old password is correct
        $old_password_ok = false;
        if (empty($new_password1) == false and empty($new_password2) == false) {
            $statement = 'SELECT * FROM users WHERE username = :username LIMIT 1';
            $params = array('username' => $username);
            $result = $db->run($statement, $params);
            $password_in_database = $result[0]['password'];
            $db->close();

            require $root.'classes/PasswordStorage.php';
            $pwd = new PasswordStorage();
            $old_password_ok = $pwd->verify_password($old_password, $password_in_database);
        }

        if ($old_password_ok == true && $new_password1 === $new_password2) {
            $valid_new_password = $pwd->create_hash($new_password1);
            $password_updated = true;
        } else {
            $password_updated = false;
        }

        // User avatar and thumbnail
        if (isset($_FILES['avatar']) == true and $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
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

        // PUT http://www.vortechmusic.com/api/v1/users/:username
        $api = SERVER_URL.'api/v1/users/'.$_SESSION['username'];

        // Generate the PUT request
        $data = array(
            'display_name' => $display_name,
            'username' => $username,
            'caption' => $caption,
        );
        if ($password_updated == true && empty($valid_new_password) == false) {
            $data['new_password'] = $valid_new_password;
        }
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'PUT',
                'content' => http_build_query($data),
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($api, false, $context);
        // For UPDATE, to check if anything happened, we must check "rowCount"
        if ($result === false) {
            $response['status'] = 'error';
            $response['message'] = 'Could not update to DB';
        } else {
            $response['status'] = 'success';
            $response['message'] = 'Updated DB successfully';
        }
    } else {
        if (isset($_SESSION['authorized']) == false) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Missing required data';
        }
    }

    header('Content-type: application/json');
    echo json_encode($response);