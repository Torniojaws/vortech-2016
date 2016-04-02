<?php

    require_once 'visitor-update-api.php';

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
                    $result = new VisitorUpdateAPI($request, $inputData);
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
