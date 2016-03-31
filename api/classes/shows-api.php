<?php

    class ShowsAPI
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

                # /shows
                case isset($args[2]) == false and isset($filters) == false:
                    $query['statement'] = 'SELECT * FROM shows';
                    $query['params'] = array();
                    break;

                # /shows?year=2015
                case isset($args[2]) == false and isset($filters):
                    // Expected parse_str variables are "year" and optionally "month"
                    parse_str($filters);
                    $query['statement'] = 'SELECT * FROM shows WHERE YEAR(show_date) = :year';
                    $query['params'] = array("year" => (int)$year);
                    if(isset($month)) {
                        $query['statement'] .= ' AND MONTH(posted) = :month';
                        $query['params']['month'] = (int)$month;
                    }
                    break;

                # /shows/:id
                case isset($args[2]) and isset($args[3]) == false:
                    $query['statement'] = 'SELECT * FROM shows WHERE id = :id LIMIT 1';
                    $query['params'] = array("id" => (int)$args[2]);
                    break;

                # /shows/:id/comments
                case isset($args[2]) and isset($args[3]) and isset($args[4]) == false:
                    $query['statement'] = 'SELECT show_comments.*, users.id AS userid, users.photo_id, users.name AS username
                                           FROM show_comments
                                           LEFT JOIN users ON users.id = show_comments.author_id
                                           WHERE show_id = :id';
                    $query['params'] = array("id" => (int)$args[2]);
                    break;

                # /shows/:id/comments/:id
                case isset($args[2]) and isset($args[3]) and isset($args[4]):
                    $query['statement'] = 'SELECT show_comments.*, users.id AS userid, users.photo_id, users.name AS username
                                           FROM show_comments
                                           LEFT JOIN users ON users.id = show_comments.author_id
                                           WHERE comment_subid = :id AND show_id = :show_id LIMIT 1';
                    $query['params'] = array("id" => (int)$args[4], "show_id" => (int)$args[2]);
                    break;

                # Show all - same as /shows
                default:
                    $query['statement'] = 'SELECT * FROM shows ORDER BY show_date DESC';
                    $query['params'] = array();
            }
            return $query;
        }

    }
