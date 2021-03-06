<?php

    /**
     * All webpage routes will be handled here. The most common routes are eg.
     * http://www.website.com               Will go to index
     * http://www.website.com/news          Opens template news.php
     * http://www.website.com/photos/live   Opens template photos-live.php.
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
        private $parameters;

        public function __construct()
        {
            $this->routes = $this->getFullRoute();
            $this->last_URI = end($this->routes);
            $this->second_last_URI = $this->getSecondLastURI();
            $this->buildTemplatePath();
        }

        public function getTemplate()
        {
            $parameters = $this->parameters;
            require $this->template_path;
        }

        private function getFullRoute()
        {
            $uri = $_SERVER['REQUEST_URI'];
            // GET parameters, eg. www.example.com/page?param=1
            list($uri, $params) = explode('?', $uri);
            if (empty($params) == false) {
                $this->parameters = $params;
            }
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
                $target = './apps/admin/index.php';
            } else {
                if ($this->second_last_URI == 'photos') {
                    $target = './apps/photos/index.php';
                    $_GET['page'] = $this->last_URI;
                } else {
                    $target = './apps/'.$this->last_URI.'/index.php';
                }
            }
            if (file_exists($target) == false) {
                $target = './apps/main/index.php';
            }

            $this->template_path = $target;
        }
    }
