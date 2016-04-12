<?php

    class ImageResizer
    {
        private $rootpath;
        private $thumbnailCreatedSuccessfully;

        public function __construct($rootpath)
        {
            $this->rootpath = $rootpath;
            $this->thumbnailCreatedSuccessfully = false;
        }

        public function createThumbnail($original, $target_path, $target_file, $target_width)
        {
            $format = '';
            $image_jpg = imagecreatefromjpeg($original);
            $image_png = imagecreatefrompng($original);
            $image_gif = imagecreatefromgif($original);

            if ($image_jpg) {
                $source_image = $image_jpg;
                $format = 'jpg';
            } elseif ($image_png) {
                $source_image = $image_png;
                $format = 'png';
            } elseif ($image_gif) {
                $source_image = $image_gif;
                $format = 'gif';
            }
            $width = imagesx($source_image);
            $height = imagesy($source_image);

            // Get the target height
            $target_height = floor($height * ($target_width / $width));
            $virtual_image = imagecreatetruecolor($target_width, $target_height);

            // Create the thumbnail
            imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $target_width,
                               $target_height, $width, $height);

            if (is_writable($this->rootpath.$target_path)) {
                if ($format == 'jpg') {
                    if (imagejpeg($virtual_image, $this->rootpath.$target_path.$target_file, 80)) {
                        $this->thumbnailCreatedSuccessfully = true;
                    }
                } elseif ($format == 'png') {
                    if (imagepng($virtual_image, $this->rootpath.$target_path.$target_file, 6, PNG_NO_FILTER)) {
                        $this->thumbnailCreatedSuccessfully = true;
                    }
                } elseif ($format == 'gif') {
                    if (imagegif($virtual_image, $this->rootpath.$target_path.$target_file)) {
                        $this->thumbnailCreatedSuccessfully = true;
                    }
                }
            }
        }

        public function thumbnailStatus()
        {
            return $this->thumbnailCreatedSuccessfully;
        }
    }
