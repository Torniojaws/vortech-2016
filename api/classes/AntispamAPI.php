<?php

    class AntispamAPI
    {
        public $result;

        public function __construct($request, $filters = null)
        {
            $this->result = $this->getQuery($request, $filters);
        }

        public function getResult()
        {
            return $this->result;
        }

        private function getQuery($args, $filters = null)
        {
            switch ($args) {
                # /antispam
                case isset($args[2]) == false and isset($filters) == false:
                    $query['statement'] = 'SELECT id, question FROM antispam';
                    $query['params'] = array();
                    break;

                # /antispam/:id
                case isset($args[2]) and is_numeric($args[2]) and isset($filters) == false:
                    $query['statement'] = 'SELECT id, question
                                           FROM antispam
                                           WHERE id = :id
                                           LIMIT 1';
                    $query['params'] = array('id' => (int) $args[2]);
                    break;

                # /antispam/count
                case isset($args[2]) and $args[2] == 'count' and isset($filters) == false:
                    $query['statement'] = 'SELECT count(*) AS count
                                           FROM antispam';
                    $query['params'] = array();
                    break;

                default:
                    $query['statement'] = 'SELECT id, question FROM antispam';
                    $query['params'] = array();
                    break;
            }

            return $query;
        }
    }
