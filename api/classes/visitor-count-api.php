<?php

    class VisitorCountAPI
    {
        public $result;

        public function __construct($request)
        {
            $this->result = $this->getQuery($request);
        }

        public function getResult()
        {
            return $this->result;
        }

        private function getQuery($args)
        {
            switch($args) {
                # /visitors
                case isset($args[2]) == false:
                    $query['statement'] = 'SELECT count FROM visitor_count LIMIT 1';
                    $query['params'] = array();
                    break;
            }
            return $query;
        } // getQuery()

    }
