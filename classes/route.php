<?php

    /**
     * All webpage routes will be handled here. The most common routes are eg.
     * http://www.website.com               Will go to index
     * http://www.website.com/news          Opens template news.php
     * http://www.website.com/photos/live   Opens template photos-live.php
     *
     * The API is a special case which is also handled here
     * eg. http://www.website.com/api/v1/endpoint
     */
    class Route
    {

        private $routes = array();
        private $last_URI;
        private $second_last_URI;
        private $template_path;

        public function __construct()
        {
            $this->routes = $this->getFullRoute();
            $this->last_URI = end($this->routes);
            $this->second_last_URI = $this->getSecondLastURI();
            $this->buildTemplatePath();
        }

        public function getTemplate()
        {
            require($this->template_path);
        }

        private function getFullRoute()
        {
            $uri = $_SERVER['REQUEST_URI'];
            $routelist = explode('/', $uri);
            foreach ($routelist as $route) {
                if(trim($route) != "") {
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
            if($this->last_URI == 'api') {
                $target = './api/index.php';
            } else {
                if($this->second_last_URI == 'photos') {
                    $target = "./templates/photos-" . $this->last_URI . ".php";
                } else {
                    $target = './templates/' . $this->last_URI . '.php';
                }
            }
            if(file_exists($target) == false) {
                $target = './templates/main.php';
            }
            $this->template_path = $target;
        }

    }
