<?php

    session_start();
    require_once 'EditValue.php'; // Parent class

    /**
     * When user wants to edit a profile's details inline, it sends a PUT request to the endpoint.
     */
    class EditProfile extends EditValue
    {
        private $user_id;
        private $display_name;
        private $username;
        private $caption;
        private $old_username;
        private $old_password;
        private $new_password1;
        private $new_password2;
        private $user_password_in_database;

        private $user_has_avatar = false;
        private $hashed_new_password;
        private $password_updated = false;
        // If user uploads a file of new datatype (eg. JPG -> PNG)
        private $new_filename;
        private $new_thumbnail;

        public function __construct($postData, $root)
        {
            if ($this->user_logged() == true) {
                $this->root = $root;
                require_once $this->root.'constants.php';

                $this->display_name = $postData['profileName'];
                $this->username = $postData['profileUsername'];
                $this->old_username = $postData['profileOldUsername'];
                $this->caption = $postData['profileCaption'];
                $this->old_password = $postData['profileOldPassword'];
                $this->new_password1 = $postData['profileNewPassword1'];
                $this->new_password2 = $postData['profileNewPassword2'];

                $this->getUserDetails();
                $this->updatePassword(); // Only when new one is set by user
                $this->updateUserAvatar();

                // eg. PUT // PUT http://www.vortechmusic.com/api/v1/users/:username
                $this->endpoint = SERVER_URL.'api/v1/users/'.$this->old_username;
                $this->payload = $this->buildRequest();
            } else {
                header('HTTP/1.1 401 Unauthorized');
                exit;
            }
        }

        /**
         * Sends the request to API and builds a response message based on results.
         *
         * @return $response The results of the request in an array
         */
        public function commitEdit()
        {
            $request = file_get_contents($this->endpoint, false, $this->payload);
            if ($request === false) {
                $response['status'] = 'error';
                $response['message'] = 'Could not update to DB';
            // User changed username, force a logout
            } elseif ($this->old_username != $this->username) {
                $response['status'] = 'logout';
                $response['message'] = 'Username was changed successfully - logging out...';
            // User changed password, force a logout
            } elseif ($this->password_updated == true) {
                $response['status'] = 'logout';
                $response['message'] = 'Password was changed successfully - logging out...';
            } else {
                $response['status'] = 'success';
                $response['message'] = 'Updated DB successfully';
            }

            return $response;
        }

        /**
         * Create the PUT request to be sent to API.
         *
         * @return $payload The request context to be used in the PUT request
         */
        private function buildRequest()
        {
            $data = array(
                'display_name' => $this->display_name,
                'username' => $this->username,
                'caption' => $this->caption,
                'old_username' => $this->old_username,
            );
            if ($this->password_updated == true && empty($this->hashed_new_password) == false) {
                $data['new_password'] = $this->hashed_new_password;
            }
            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'PUT',
                    'content' => http_build_query($data),
                ),
            );

            return stream_context_create($options);
        }

        /**
         * Retrieve some existing user data from the DB.
         */
        private function getUserDetails()
        {
            require_once $this->root.'api/classes/Database.php';
            $db = new Database();
            $db->connect();
            $statement = 'SELECT * FROM users WHERE username = :username LIMIT 1';
            $params = array('username' => $this->username);
            $result = $db->run($statement, $params);
            $user = $result[0];
            $db->close();

            $this->user_password_in_database = $user['password'];
            $this->user_id = $user['id'];

            // Check if user has an existing Avatar
            $db->connect();
            $statement = 'SELECT thumbnail FROM photos WHERE user_id = :user_id LIMIT 1';
            $params = array('user_id' => $this->user_id);
            $photo_result = $db->run($statement, $params);
            $avatar = $photo_result[0];
            $db->close();
            if (empty($avatar['thumbnail'])) {
                $this->user_has_avatar = false;
            } else {
                $this->user_has_avatar = true;
            }
        }

        /**
         * When user wants to update the account password, we'll check existing
         * details and make a new hashed one.
         */
        private function updatePassword()
        {
            require_once $this->root.'classes/PasswordStorage.php';
            $pwd = new PasswordStorage();

            if (empty($this->new_password1) == false and empty($this->new_password2) == false) {
                $old_password_ok = $pwd->verify_password($old_password, $this->user_password_in_database);
            }

            if ($old_password_ok == true && $this->new_password1 === $this->new_password2) {
                $this->hashed_new_password = $pwd->create_hash($new_password1);
                $this->password_updated = true;
            } else {
                $this->password_updated = false;
            }
        }

        private function updateUserAvatar()
        {
            if (isset($_FILES['avatar']) == true and $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
                require_once $this->root.'classes/ImageProcessing.php';

                $path = 'user_photos/';
                $images = new ImageProcessing($this->root, $path, $this->user_id);
                $images->processUploadedFile();
                $images->createThumbnailForUpload();

                if ($images->imagesUploadedSuccessfully() && $images->thumbnailsCreatedSuccessfully()) {
                    $images->renameUploadedFiles();
                    $this->new_filename = $images->getFilename();
                    $this->new_thumbnail = $images->getThumbnailFilename();
                    $this->updateAvatarInDatabase();
                }
            }
        }

        /**
         * Updates the user avatar details in the database.
         */
        private function updateAvatarInDatabase()
        {
            require_once $this->root.'api/classes/Database.php';
            $db = new Database();
            $db->connect();

            if ($this->user_has_avatar == false) {
                // User did not upload an avatar when registering. Will add a new one now.
                $statement = 'INSERT INTO photos VALUES(
                    0,
                    :album_id,
                    :photo_date,
                    :taken_by,
                    :full,
                    :thumbnail,
                    :caption,
                    :user_id
                )';
                $params = array(
                    'album_id' => 7,
                    'photo_date' => date('Y-m-d H:i:s'),
                    'taken_by' => $this->display_name,
                    'full' => $this->new_filename,
                    'thumbnail' => $this->new_thumbnail,
                    'caption' => $this->display_name,
                    'user_id' => $this->user_id,
                );
            } else {
                // User replaces an existing avatar, we will update it
                $statement = 'UPDATE photos
                              SET full = :full,
                                  thumbnail = :thumbnail
                              WHERE taken_by = :display_name
                                    AND album_id = :album_id';
                $params = array(
                    'display_name' => $this->display_name,
                    'full' => $this->new_filename,
                    'thumbnail' => $this->new_thumbnail,
                    'album_id' => (int) 7,
                );
            }
            $result = $db->run($statement, $params);
            $db->close();
        }

        private function user_logged()
        {
            return isset($_SESSION) and $_SESSION['user_logged'] == 1;
        }
    }
