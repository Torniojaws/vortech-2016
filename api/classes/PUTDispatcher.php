<?php

    class PUTDispatcher
    {
        private $sql;

        public function __construct($original_request, $inputData)
        {
            // Remove empty elements
            $request = array_filter(explode('/', $original_request), 'strlen');
            $root = $request[1];
            switch ($root) {
                case 'visitors':
                    require_once 'VisitorUpdateAPI.php';
                    $result = new VisitorUpdateAPI($request, $inputData);
                    $this->sql = $result->getResult();
                    break;
                case 'news':
                    require_once 'NewsUpdateAPI.php';
                    $result = new NewsUpdateAPI($request, $inputData);
                    $this->sql = $result->getResult();
                    break;
                case 'guestbook':
                    require_once 'GuestbookUpdateAPI.php';
                    $result = new GuestbookUpdateAPI($request, $inputData);
                    $this->sql = $result->getResult();
                    break;
                case 'shopitems':
                    require_once 'ShopUpdateAPI.php';
                    $result = new ShopUpdateAPI($request, $inputData);
                    $this->sql = $result->getResult();
                    break;
                case 'videos':
                    require_once 'VideosUpdateAPI.php';
                    $result = new VideosUpdateAPI($request, $inputData);
                    $this->sql = $result->getResult();
                    break;
                default:
                    $this->sql = '';
            }
            $this->sql;
        }

        public function getStatement()
        {
            return $this->sql['statement'];
        }

        public function getParams()
        {
            return $this->sql['params'];
        }
    }
