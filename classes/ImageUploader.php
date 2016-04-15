<?php

    class ImageUploader
    {
        private $root_dir;
        private $upload_path;
        private $uploaded_photos_count = 0;
        private $errors = 0;
        private $uploadedFiles = array();

        public function __construct($root, $upload_path)
        {
            $this->root_dir = $root;
            $this->upload_path = $upload_path;
        }

        public function processUploadedImages()
        {
            foreach ($_FILES as $file => $details) {
                $tmp = $details['tmp_name'];
                $filename = $details['name'];

                if ($this->file_is_valid($details['size'], $filename) == false) {
                    continue;
                }

                // Process the file if everything checks out
                if (move_uploaded_file($tmp, $this->upload_path.$filename)) {
                    // This is mostly used in thumbnail creation
                    $image['fullpath'] = $this->upload_path;
                    $image['filename'] = $filename;
                    $this->uploadedFiles[] = $image;
                    $this->uploaded_photos_count += 1;
                } else {
                    echo 'ImageUploader:
                          Could not move image ['.$target.']
                          to ['.$this->upload_path.']';
                    $this->errors += 1;
                }
            }
        }

        public function successfullyUploadedAll()
        {
            return $this->errors == 0;
        }

        public function getAssocArrayOfUploadedImages()
        {
            return $this->uploadedFiles;
        }

        private function file_is_valid($filesize, $filename)
        {
            if ($filesize == 0) {
                echo 'ImageUploader: Empty file';
                $this->errors += 1;

                return false;
            }
            if (preg_match('`^[-0-9A-Z_\.]+$`i', $filename) == false) {
                echo 'ImageUploader: Invalid filename';
                $this->errors += 1;

                return false;
            }
            if (mb_strlen($filename, 'UTF-8') > 250) {
                echo 'ImageUploader: Too long filename length';
                $this->errors += 1;

                return false;
            }
            $allowed_file_extensions = array('gif', 'jpg', 'jpeg', 'png');
            $file_ext = strtolower(pathinfo($filename)['extension']);
            if (in_array($file_ext, $allowed_file_extensions) == false) {
                echo 'ImageUploader: Unallowed file type';
                $this->errors += 1;

                return false;
            }

            return true;
        }
    }
