<?php

    session_start();
    require_once '../../../constants.php';

    // Because this runs from a subdir
    $root = str_replace('apps/profile/edit', '', dirname(__FILE__));

    if (isset($_SESSION) && $_SESSION['user_logged'] == 1 && isset($_POST)) {
        // Values from the form
        $display_name = $_POST['profileName'];
        $username = $_POST['profileUsername'];
        $old_username = $_POST['profileOldUsername'];
        $caption = $_POST['profileCaption'];
        $old_password = $_POST['profileOldPassword'];
        $new_password1 = $_POST['profileNewPassword1'];
        $new_password2 = $_POST['profileNewPassword2'];

        // Get details:
        require_once $root.'api/classes/Database.php';
        $db = new Database();
        $db->connect();
        $statement = 'SELECT * FROM users WHERE username = :username LIMIT 1';
        $params = array('username' => $username);
        $result = $db->run($statement, $params);
        $db->close();

        $password_in_database = $result[0]['password'];
        $user_id = $result[0]['id'];

        // Password update
        require $root.'classes/PasswordStorage.php';
        $pwd = new PasswordStorage();

        // Check that old password is correct
        $old_password_ok = false;
        if (empty($new_password1) == false and empty($new_password2) == false) {
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

            // Rename uploaded file to "user_id.ext", eg. 123.jpg
            $extension = pathinfo($full_image, PATHINFO_EXTENSION);
            $new_name = $user_id.'.'.$extension; // 123.jpg
            $new_thumb = 'thumbnails/'.$new_name;

            if (rename($absolute_upload_path.$full_image,
                       $absolute_upload_path.$new_name) == false
            ) {
                $image_errors += 1;
            };
            if (rename($absolute_upload_path.'thumbnails/'.$full_image,
                       $absolute_upload_path.'thumbnails/'.$new_name) == false
            ) {
                $thumbnail_errors += 1;
            }

            // Since the filetype could be different, eg. user had 1.jpg and now uploaded 1.png,
            // we need to update the "photos" table too
            $db = new Database();
            $db->connect();
            $statement = 'UPDATE photos
                          SET full = :full,
                              thumbnail = :thumbnail
                          WHERE taken_by = :display_name
                                AND album_id = :album_id';
            $params = array(
                'display_name' => $display_name,
                'full' => $new_name,
                'thumbnail' => $new_thumb,
                'album_id' => (int) 7,
            );
            $result = $db->run($statement, $params);
            $db->close();
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
            'old_username' => $old_username,
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
        if ($result === false) {
            $response['status'] = 'error';
            $response['message'] = 'Could not update to DB';
        // User changed username, force a logout
        } elseif ($old_username != $username) {
            $response['status'] = 'logout';
            $response['message'] = 'Username was changed successfully - logging out...';
        // User changed password, force a logout
        } elseif ($password_updated == true) {
            $response['status'] = 'logout';
            $response['message'] = 'Password was changed successfully - logging out...';
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
