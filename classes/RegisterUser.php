<?php

    // TODO: This needs some refactoring later
    // Perhaps return an User object instead?

    class RegisterUser
    {
        private $display_name;
        private $username;
        private $password1;
        private $password2;
        private $password_secure;
        private $date_of_photos;
        private $full_image;
        private $thumbnail;
        private $uploads;
        private $successfully_registered = false;
        private $password_is_valid = false;
        private $image_was_uploaded = false;
        private $root_path;

        public function __construct($root)
        {
            $this->root_path = $root;
            if (isset($_FILES['file_upload']) == true
                and $_FILES['file_upload']['error'] !== UPLOAD_ERR_NO_FILE) {
                $this->image_was_uploaded = true;
            } else {
                $this->image_was_uploaded = false;
            }
        }

        public function register($name, $username, $pw1, $pw2)
        {
            $this->display_name = $name;
            $this->username = $username;
            $this->password1 = $pw1;
            $this->password2 = $pw2;

            $this->validate_password();

            /**
             * If user has uploaded an image, it will be processed before
             * continuing with the user account creation
             */
            $image_errors = 0;
            if ($this->image_was_uploaded == true) {
                $image = $this->upload_image();
                $this->create_thumbnail($image);

                if ($imageUploader->successfullyUploadedAll() == false) {
                    $image_errors += 1;
                }
                if ($resizer->thumbnailStatus() == false) {
                    $image_errors += 1;
                }

                $this->full_image = $image['filename'];
                $this->thumbnail = 'thumbnails/'.$image['filename'];
            }

            if ($this->password_is_valid and $image_errors == 0) {
                $this->successfully_registered = true;
            } else {
                $this->successfully_registered = false;
            }

            return $this->successful();
        }

        public function successful()
        {
            return $this->successfully_registered;
        }

        public function getPhotoDate()
        {
            return $this->date_of_photos;
        }
        public function getUploadedImages()
        {
            return $this->uploads;
        }
        public function imageWasUploaded()
        {
            return $this->image_was_uploaded;
        }
        public function getFullImageFilename()
        {
            return $this->full_image;
        }
        public function getThumbnailFilename()
        {
            return $this->thumbnail;
        }
        public function getHashedPassword()
        {
            return $this->password_secure;
        }

        /**
         * Makes sure that the password given by the user is valid and then
         * converts it to the secure hashed form using the 3rd party library.
         *
         * @return Creates error status JSON
         */
        private function validate_password() {
            if ($this->password1 === $this->password2) {
                require $this->root_path.'classes/PasswordStorage.php';
                $pwd = new PasswordStorage();
                try {
                    $this->password_secure = $pwd->create_hash($this->password1);
                    $this->password_is_valid = true;
                } catch (Exception $ex) {
                    echo $ex;
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Passwords do not match';
                header('Content-type: application/json');
                echo json_encode($response);
                return;
            }
        }

        /**
         * Process the image from the form. It will be written to a predetermined
         * directory in the standard images folder defined in the site constants.
         *
         * @return $uploads Array containing all uploaded images' details
         */
        private function upload_image()
        {
            $path_for_uploads = 'user_photos/';
            require_once $this->root_path.'classes/ImageUploader.php';
            $absolute_upload_path = $this->root_path.IMAGE_DIR.$path_for_uploads;

            $this->date_of_photos = date('Y-m-d H:i:s');

            $imageUploader = new ImageUploader($this->root_path, $absolute_upload_path);
            $imageUploader->processUploadedImages();
            // Each array element contains info about one successfully uploaded image
            $this->uploads = $imageUploader->getAssocArrayOfUploadedImages();
            return $this->uploads;
        }

        /**
         * Create thumbnails for uploaded images. The thumbnails will be in a
         * subdirectory "thumbnails" under the main user image upload directory.
         */
        private function create_thumbnail($uploads)
        {
            require_once $this->root_path.'classes/ImageResizer.php';
            $resizer = new ImageResizer($this->root_path);

            foreach ($uploads as $image) {
                $resizer->createThumbnail(
                    $image['fullpath'].$image['filename'],
                    $absolute_upload_path.'thumbnails/',
                    $image['filename'],
                    64
                );
                // All user-uploaded avatars start with the display name as caption
                // but the user can later edit them
                $caption = $this->display_name;
            }
        }
    }
