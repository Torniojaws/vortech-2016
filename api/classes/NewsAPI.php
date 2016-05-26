<?php

    class NewsAPI
    {
        public $result;

        public function __construct($request, $filters)
        {
            $this->result = $this->getQuery($request, $filters);
        }

        public function getResult()
        {
            return $this->result;
        }

        private function getQuery($args, $filters)
        {
            $base_sql = 'SELECT * FROM news';

            switch ($args) {
                # /news
                case isset($args[2]) == false and isset($filters) == false:
                    $query['statement'] = $base_sql.' ORDER BY posted DESC';
                    $query['params'] = array();
                    break;

                # /news?year=2015
                case isset($args[2]) == false and isset($filters):
                    // Expected parse_str variables are "tag", "year" and optionally "month"
                    parse_str($filters);

                    # /news?tag=test
                    if (isset($tag)) {
                        $query['statement'] = $base_sql.' WHERE tags LIKE :tag';
                        $query['params'] = array('tag' => '%'.$tag.'%');
                    }

                    # /news?year=2015
                    if (isset($year)) {
                        $query['statement'] = $base_sql.' WHERE YEAR(posted) = :year';
                        $query['params'] = array('year' => (int) $year);
                    }

                    # /news?year=2015&month=3
                    if (isset($month)) {
                        $query['statement'] .= ' AND MONTH(posted) = :month';
                        $query['params']['month'] = (int) $month;
                    }
                    // We don't want to run a query when "showModal" is set
                    if (isset($showModal) == false) {
                        $query['statement'] .= ' ORDER BY posted DESC';
                    }
                    break;

                # /news/:id
                case isset($args[2]) and isset($args[3]) == false:
                    $query['statement'] = $base_sql.' WHERE id = :id
                                           ORDER BY posted DESC
                                           LIMIT 1';
                    $query['params'] = array('id' => (int) $args[2]);
                    break;

                # /news/:id/comments
                case isset($args[2]) and isset($args[3]):
                    $query['statement'] = 'SELECT * FROM news_comments WHERE news_id = :id';
                    $query['params'] = array('id' => (int) $args[2]);

                    # /news/:id/comments/:id
                    if (isset($args[4])) {
                        $query['statement'] .= ' AND news_id = :news_id LIMIT 1';
                        $query['params']['news_id'] .= (int) $args[2];
                    }
                    break;

                # Show all - same as /news
                default:
                    $query['statement'] = 'SELECT * FROM news ORDER BY posted DESC';
                    $query['params'] = array();
            }

            return $query;
        } // getQuery()
    }
