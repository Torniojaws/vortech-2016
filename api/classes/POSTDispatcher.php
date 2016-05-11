<?php

    class POSTDispatcher
    {
        private $sql;

        public function __construct($original_request, $filters, $inputData)
        {
            // Remove empty elements
            $request = array_filter(explode('/', $original_request), 'strlen');
            $root = $request[1];
            switch ($root) {
                case 'photos':
                    require_once 'PhotosPostAPI.php';
                    $result = new PhotosPostAPI($request, $filters, $inputData);
                    $this->sql = $result->getResult();
                    break;
                case 'votes':
                    require_once 'VotesPostAPI.php';
                    $result = new VotesPostAPI($request, $filters, $inputData);
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
