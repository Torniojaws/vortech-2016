<?php

    class ReleasesAPI
    {
        public $result;

        public function __construct($request, $filters=null)
        {
            $this->result = $this->getQuery($request, $filters);
        }

        public function getResult() {
            return $this->result;
        }

        private function getQuery($args, $filters=null) {
            switch($args) {

                # /releases
                case isset($args[2]) == false and isset($filters) == false:
                    $query['statement'] = 'SELECT * FROM releases';
                    $query['params'] = array();
                    break;

                # /releases?year=2015
                case isset($args[2]) == false and isset($filters):
                    // Expected parse_str variable is "year"
                    parse_str($filters);
                    if(isset($year)) {
                        $query['statement'] = 'SELECT * FROM releases WHERE YEAR(release_date) = :year';
                        $query['params'] = array("year" => (int)$year);
                    } else if(isset($yearrange)) {
                        list($yearstart, $yearend) = explode('-', $yearrange);
                        $query['statement'] = 'SELECT * FROM releases WHERE YEAR(release_date) BETWEEN :yearstart AND :yearend';
                        $query['params'] = array("yearstart" => (int)$yearstart, "yearend" => (int)$yearend);
                    }
                    break;

                # /releases/:id
                case isset($args[2]) and isset($args[3]) == false:
                    $query['statement'] = 'SELECT * FROM releases WHERE id = :id LIMIT 1';
                    $query['params'] = array("id" => (int)$args[2]);
                    break;

                # /releases/:id/comments
                case isset($args[2]) and isset($args[3]) and isset($args[4]) == false:
                    $query['statement'] = 'SELECT * FROM release_comments WHERE release_id = :id';
                    $query['params'] = array("id" => (int)$args[2]);
                    break;

                # /releases/:id/comments/:id
                case isset($args[2]) and isset($args[3]) and isset($args[4]):
                    $query['statement'] = 'SELECT * FROM release_comments WHERE id = :id AND release_id = :release_id LIMIT 1';
                    $query['params'] = array("id" => (int)$args[4], "release_id" => (int)$args[2]);
                    break;

                # Show all - same as /releases
                default:
                    $query['statement'] = 'SELECT * FROM releases ORDER BY release_date DESC';
                    $query['params'] = array();
            }
            return $query;
        }

    }
