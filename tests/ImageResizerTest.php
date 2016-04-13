<?php

    class ImageResizerTest extends PHPUnit_Framework_TestCase
    {
        public function testCanAccessDestinationDirectories()
        {
            $directories = array(
                'static/img/band_members/',
                'static/img/band_members/thumbnails/',
                'static/img/live/',
                'static/img/live/thumbnails/',
                'static/img/merch/',
                'static/img/merch/thumbnails/',
                'static/img/misc/',
                'static/img/misc/thumbnails/',
                'static/img/promo/',
                'static/img/promo/thumbnails/',
                'static/img/studio/',
                'static/img/studio/thumbnails/',
                'static/img/user_photos/',
                'static/img/user_photos/thumbnails/',
                'static/img/videos/',
                'static/img/videos/thumbnails/',
            );
            $errors = 0;
            foreach ($directories as $dir) {
                if (is_writable($dir) == false) {
                    $errors += 1;
                }
            }

            $this->assertEquals(0, $errors);
        }

        public function testCanResizeJPG()
        {
            $picture = 'tests/test.jpg';
            $image = imagecreatefromjpeg($picture);

            $width = imagesx($image);
            $height = imagesy($image);
            $thumb_width = 128;
            $thumb_height = 96;
            $target_height = floor($height * ($thumb_width / $width));

            $virtual_image = imagecreatetruecolor($thumb_width, $thumb_height);
            imagecopyresampled(
                $virtual_image, $image, 0, 0, 0, 0, $thumb_width,
                $thumb_height, $width, $height
            );

            $image_ok = false;
            if (imagejpeg($virtual_image, 'tests/thumbnail.jpg', 80)) {
                $image_ok = true;
            } else {
                $image_ok = false;
            }

            unlink('tests/thumbnail.jpg');

            $this->assertEquals(true, $image_ok);
        }
    }