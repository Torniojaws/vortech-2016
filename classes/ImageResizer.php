<?php

    class ImageResizer
    {
        private $thumbnailCreatedSuccessfully;
        private $format;
        private $rootpath;

        public function __construct()
        {
            $this->thumbnailCreatedSuccessfully = false;
        }

        /**
         * The main function of this class is to take a photo that was uploaded in a form
         * and create a thumbnail for it in the correct directory, which is a subdir called
         * "thumbnails", directly under the directory of the original fullsize photo.
         *
         * @param $original The path of the original fullsize picture, including filename
         * @param $target_path The relative path where the thumbnail will be created
         * @param $target_file The filename for the thumbnail - same as original
         * @param $target_width The intended width for the thumbnail.
         */
        public function createThumbnail($original, $target_path, $target_file, $target_width)
        {
            // Setup
            $this->thumbnail_path = $this->rootpath.$target_path.$target_file;
            $source_image = $this->processOriginalPhoto($original);

            // For resizing the thumbnail
            $width = imagesx($source_image);
            $height = imagesy($source_image);
            $target_height = floor($height * ($target_width / $width));

            // Create the thumbnail
            $virtual_image = imagecreatetruecolor($target_width, $target_height);
            if (imagecopyresampled(
                $virtual_image,
                $source_image,
                0, 0, 0, 0,
                $target_width,
                $target_height,
                $width,
                $height
            ) == false) {
                echo 'Resizer: Could not process image';
            }

            // And write it to the target path
            if (is_writable($this->rootpath.$target_path)) {
                $this->createFile($virtual_image);
            } else {
                echo 'Resizer: Cannot write to ['.$this->rootpath.$target_path.']';
            }
        }

        public function thumbnailStatus()
        {
            return $this->thumbnailCreatedSuccessfully;
        }

        /**
         * Creates the actual thumbnail file to target directory. The property
         * set by this is used for checking if the thumbnail was successfully
         * created.
         *
         * @param $format The file format of the picture
         */
        private function createFile($virtual_image)
        {
            if ($this->format == 'jpg') {
                if (imagejpeg(
                        $virtual_image,
                        $this->thumbnail_path,
                        80
                    )) {
                    $this->thumbnailCreatedSuccessfully = true;
                }
            } elseif ($this->format == 'png') {
                if (imagepng(
                        $virtual_image,
                        $this->thumbnail_path,
                        6,
                        PNG_NO_FILTER
                    )) {
                    $this->thumbnailCreatedSuccessfully = true;
                }
            } elseif ($this->format == 'gif') {
                if (imagegif(
                        $virtual_image,
                        $this->thumbnail_path
                    )) {
                    $this->thumbnailCreatedSuccessfully = true;
                }
            }
        }

        /**
         * Parse the original picture and see which format it is in.
         * Then return the resource for thumbnail creation.
         *
         * @param $original The original image
         *
         * @return $source_image The processed source image resource for thumbnail creation
         */
        private function processOriginalPhoto($original)
        {
            $image_jpg = imagecreatefromjpeg($original);
            $image_png = imagecreatefrompng($original);
            $image_gif = imagecreatefromgif($original);

            if ($image_jpg) {
                $source_image = $image_jpg;
                $this->format = 'jpg';
            } elseif ($image_png) {
                $source_image = $image_png;
                $this->format = 'png';
            } elseif ($image_gif) {
                $source_image = $image_gif;
                $this->format = 'gif';
            }

            return $source_image;
        }
    }
