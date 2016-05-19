<?php

    class EditValueTest extends PHPUnit_Framework_TestCase
    {
        public function __construct()
        {

        }

        public function testElementParameterValueIsCorrect()
        {
            $data = 'photocaption-2';
            list($column, $id) = explode('-', $data);

            $this->assertEquals(2, $id);
        }

        public function testTrailingSlashIsSetCorrectly()
        {
            $category = 'user_photos';
            if (strpos($category, '?') === false) {
                $category .= '/';
            }

            $this->assertEquals('user_photos/', $category);
        }

        public function testTrailingSlashIsNotSetWhenUrlHasParameters()
        {
            $category = 'photos?year=2016';
            if (strpos($category, '?') === false) {
                $category .= '/';
            }

            $this->assertEquals('photos?year=2016', $category);
        }

    }
