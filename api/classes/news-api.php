<?php

    class NewsAPI
    {
        public $result;

        public function __construct($request, $filters)
        {
            $this->result = $this->getQuery($request, $filters);
        }

        public function getResult() {
            return $this->result;
        }

        private function getQuery($args, $filters) {
            switch($args) {
                
                # /news
                case isset($args[2]) == false and isset($filters) == false:
                    $query['statement'] = 'SELECT * FROM news';
                    $query['params'] = array();
                    break;

                # /news?year=2015
                case isset($args[2]) == false and isset($filters):
                    // Expected parse_str variables are "year" and optionally "month"
                    parse_str($filters);
                    $query['statement'] = 'SELECT * FROM news WHERE YEAR(posted) = :year';
                    $query['params'] = array("year" => (int)$year);
                    if(isset($month)) {
                        $query['statement'] .= ' AND MONTH(posted) = :month';
                        $query['params']['month'] = (int)$month;
                    }
                    break;

                # /news/:id
                case isset($args[2]) and isset($args[3]) == false:
                    $query['statement'] = 'SELECT * FROM news WHERE id = :id LIMIT 1';
                    $query['params'] = array("id" => (int)$args[2]);
                    break;

                # /news/:id/comments
                case isset($args[2]) and isset($args[3]) and isset($args[4]) == false:
                    $query['statement'] = 'SELECT * FROM news_comments WHERE news_id = :id';
                    $query['params'] = array("id" => (int)$args[2]);
                    break;

                # /news/:id/comments/:id
                case isset($args[2]) and isset($args[3]) and isset($args[4]):
                    $query['statement'] = 'SELECT * FROM news_comments WHERE id = :id AND news_id = :news_id LIMIT 1';
                    $query['params'] = array("id" => (int)$args[4], "news_id" => (int)$args[2]);
                    break;

                # Show all - same as /news
                default:
                    $query['statement'] = 'SELECT * FROM news ORDER BY posted DESC';
                    $query['params'] = array();
            }
            return $query;
        }

    }
