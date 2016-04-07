<?php

    require_once 'constants.php';

    class RouteTest extends PHPUnit_Framework_TestCase
    {
        public function __construct()
        {
        }

        public function testFullRouteIsReceived()
        {
            $test_url = 'http://wwww.vortechmusic.com/photos/live';
            $routes_test = $this->getFullRoute($test_url);
            $route_count = count($routes_test);

            $this->assertEquals(4, $route_count);
        }

        public function testSecondLastRouteIsReceived()
        {
            $test_url = 'http://wwww.vortechmusic.com/photos/live';
            $testRoutes = $this->getFullRoute($test_url);
            $second_last_number = count($testRoutes) - 1 - 1;
            $second_last = $testRoutes[$second_last_number];

            $this->assertEquals('photos', $second_last);
        }

        public function testApiTemplateExistsAndIsAccessible()
        {
            $target = './api/index.php';

            if (file_exists($target)) {
                $result = true;
            } else {
                $result = false;
            }

            $this->assertEquals(true, $result);
        }

        public function testAdminTemplateExistsAndIsAccessible()
        {
            $target = './templates/admin.php';

            if (file_exists($target)) {
                $result = true;
            } else {
                $result = false;
            }

            $this->assertEquals(true, $result);
        }

        public function testNormalPageTemplateExistsAndIsAccessible()
        {
            $target = './templates/news.php';

            if (file_exists($target)) {
                $result = true;
            } else {
                $result = false;
            }

            $this->assertEquals(true, $result);
        }

        public function testNormalSubPageTemplateExistsAndIsAccessible()
        {
            $target = './templates/photos-live.php';

            if (file_exists($target)) {
                $result = true;
            } else {
                $result = false;
            }

            $this->assertEquals(true, $result);
        }

        public function testTemplateDoesNotExistAndTheCorrectAlternativeIsGiven()
        {
            $target = './templates/does-not-exist';

            if (file_exists($target) == false) {
                $alternative = './templates/main.php';
            } else {
                $alternative = 'wrong';
            }

            if (file_exists($alternative)) {
                $result = true;
            } else {
                $result = false;
            }

            $this->assertEquals(true, $result);
        }

        /* Support functions */

        private function getFullRoute($uri)
        {
            $routelist = explode('/', $uri);
            foreach ($routelist as $route) {
                if (trim($route) != '') {
                    $routes[] = $route;
                }
            }

            return $routes;
        }
    }
