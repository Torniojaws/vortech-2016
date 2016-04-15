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

    }
