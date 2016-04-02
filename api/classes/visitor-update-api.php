<?php

    class VisitorUpdateAPI
    {
        public $result;

        public function __construct($request, $data)
        {
            $this->result = $this->getQuery($request, $data);
        }

        public function getResult()
        {
            return $this->result;
        }

        private function getQuery($args, $data)
        {
            switch($args) {
                # /visitors
                case isset($args[2]) == false and isset($data):
                    // Expected to create variable "increment"
                    parse_str($data);
                    $query['statement'] = 'UPDATE visitor_count SET count = count + :increment';
                    $query['params'] = array("increment" => (int)$increment);
                    break;
                default:
                    $query = '';
            }
            return $query;
        } // getQuery()

    }
