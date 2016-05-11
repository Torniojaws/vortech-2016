<?php

    class VotesAPI
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
                # /votes
                case isset($args[2]) == false and isset($filters) == false:
                    $query['statement'] = 'SELECT * FROM votes';
                    $query['params'] = array();
                    break;

                # /votes/:category
                case isset($args[2]) and isset($args[3]) == false:
                    $query['statement'] = 'SELECT *
                                           FROM votes
                                           WHERE category = :category
                                           ORDER BY item ASC';
                    $query['params'] = array('category' => $args[2]);
                    break;

                # /votes/:category/:id
                case isset($args[3]) and is_numeric($args[3]):
                    // When querying a specific item, we want to return the calculated rating
                    $query['statement'] = 'SELECT category, item,
                                                  COUNT(*) AS votes,
                                                  ROUND(SUM(rating) / COUNT(*), 2) AS rating,
                                                  5 AS max_rating
                                           FROM votes
                                           WHERE category = :category
                                                AND item = :id';
                    $query['params'] = array(
                        'category' => $args[2],
                        'id' => (int) $args[3],
                    );
                    break;

                # Show all - same as /shows
                default:
                    $query['statement'] = 'SELECT * FROM shows ORDER BY show_date DESC';
                    $query['params'] = array();
            }

            return $query;
        } // getQuery()
    }
