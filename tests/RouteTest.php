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
            $this->assertEquals(2, $route_count);
        }

        /* Data stuff */

        public function getTemplate()
        {
            require $this->template_path;
        }

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

        // Used for special routes like /photos/live/
        private function getSecondLastURI()
        {
            // 0-index conversion and second last in array
            $second_last = count($this->routes) - 1 - 1;
            $result = $this->routes[$second_last];

            return $result;
        }

        private function buildTemplatePath()
        {
            if ($this->last_URI == 'api') {
                $target = './api/index.php';
            } elseif ($this->last_URI == 'admin') {
                $target = './templates/admin.php';
            } else {
                if ($this->second_last_URI == 'photos') {
                    $target = './templates/photos-'.$this->last_URI.'.php';
                } else {
                    $target = './templates/'.$this->last_URI.'.php';
                }
            }
            if (file_exists($target) == false) {
                $target = './templates/main.php';
            }
            $this->template_path = $target;
        }
    }
