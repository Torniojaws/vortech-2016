<?php

    class EditValueTest extends PHPUnit_Framework_TestCase
    {
        public function __construct()
        {
            // Expected to run tests in project root
            require_once 'constants.php';
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

        public function testCorrectPayloadUrlIsCreated()
        {
            $category = 'releases';
            $id = 'CD006';
            $url = SERVER_URL.'api/v1/'.$category.$id;
            if (file_get_contents($url)) {
                $result = true;
            } else {
                $result = false;
            }

            $this->assertEquals(true, $result);
        }

        public function testContextIsCreatedCorrectly()
        {
            $data = array(
                'id' => 123,
                'column' => 'photos',
                'new_value' => 'test.jpg',
            );
            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'PUT',
                    'content' => http_build_query($data),
                ),
            );

            $this->assertEquals('id=123&column=photos&new_value=test.jpg', $options['http']['content']);
        }
    }
