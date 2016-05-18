<?php

    class ImageProcessing
    {
        private $upload_path_relative;
        private $upload_path_absolute;
        private $root;
        private $images_ok = false;
        private $new_filename;
        private $new_thumb;
        private $full_image;
        private $thumbnail;
        private $uploads;
        private $image_errors = 0;
        private $thumbnail_errors = 0;
        private $user_id;

        public function __construct($root, $upload_path, $user_id)
        {
            $this->root = $root;
            $this->user_id = $user_id; // Needed for renaming uploaded files
            require_once $this->root.'constants.php'; // For IMAGE_DIR
            $this->upload_path_relative = $upload_path; // the path under IMAGE_DIR, eg. 'user_photos/'
            $this->upload_path_absolute = $this->root.IMAGE_DIR.$this->upload_path_relative;
        }

        public function processUploadedFile()
        {
            require_once $this->root.'classes/ImageUploader.php';
            $imageUploader = new ImageUploader($this->root, $this->upload_path_absolute);
            $imageUploader->processUploadedImages();
            $this->uploads = $imageUploader->getAssocArrayOfUploadedImages();
            if ($this->uploads == null) {
                $this->images_ok = false;
            } else {
                $this->images_ok = true;
            }
        }

        public function createThumbnailForUpload()
        {
            require_once $this->root.'classes/ImageResizer.php';
            $resizer = new ImageResizer();
            foreach ($this->uploads as $image) {
                $resizer->createThumbnail(
                    $image['fullpath'].$image['filename'],
                    $this->upload_path_absolute.'thumbnails/',
                    $image['filename'],
                    64 // pixels
                );
                if ($resizer->thumbnailStatus() == true) {
                    $this->full_image = $image['filename'];
                    $this->thumbnail = 'thumbnails/'.$image['filename'];
                } else {
                    $this->images_ok = false;
                }
            }
        }

        public function renameUploadedFiles()
        {
            $extension = pathinfo($this->full_image, PATHINFO_EXTENSION);
            $this->new_filename = $this->user_id.'.'.$extension; // 123.jpg
            $this->new_thumb = 'thumbnails/'.$this->new_filename;

            if (rename($this->upload_path_absolute.$this->full_image,
                       $this->upload_path_absolute.$this->new_filename) == false
            ) {
                $this->image_errors += 1;
            };
            if (rename($this->upload_path_absolute.'thumbnails/'.$this->full_image,
                       $this->upload_path_absolute.'thumbnails/'.$this->new_filename) == false
            ) {
                $this->thumbnail_errors += 1;
            }

            $this->deleteOldImages();
        }

        /**
         * When user uploads a new image of different extension, we need to clean up
         * the old file that would otherwise stay in the dir
         */
        private function deleteOldImages()
        {
            if ($this->thumbnailsCreatedSuccessfully()) {
                // Clean full images
                $avatar_files = glob($this->upload_path_absolute.$this->user_id.'.*');
                foreach ($avatar_files as $avatar) {
                    if ($avatar != $this->upload_path_absolute.$this->new_filename) {
                        unlink($avatar);
                    }
                }
                // Clean thumbnails
                $thumb_files = glob($this->upload_path_absolute.'thumbnails/'.$this->user_id.'.*');
                foreach ($thumb_files as $thumb) {
                    if ($thumb != $this->upload_path_absolute.'thumbnails/'.$this->new_filename) {
                        unlink($thumb);
                    }
                }
            }
        }

        public function imagesUploadedSuccessfully()
        {
            return $this->images_ok;
        }

        public function thumbnailsCreatedSuccessfully()
        {
            return ($this->image_errors == 0 and $this->thumbnail_errors == 0);
        }

        public function getFilename()
        {
            return $this->new_filename;
        }

        public function getThumbnailFilename()
        {
            return $this->new_thumb;
        }
    }
