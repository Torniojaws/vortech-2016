<?php

    $root = str_replace('api/classes', '', __DIR__);
    require $root.'constants.php';

    class VotesPostAPI
    {
        public $result;

        public function __construct($request, $filters = null, $data)
        {
            $this->result = $this->getQuery($request, $filters, $data);
        }

        public function getResult()
        {
            return $this->result;
        }

        private function getQuery($args, $filters = null, $data)
        {
            switch ($args) {

                # /votes/:category/:id
                case isset($args[2]) and in_array($args[2], array('releases', 'songs', 'photos'))
                     and isset($args[3]) and is_numeric($args[3]):
                    // Expecting to create variable for Rating
                    parse_str($data);
                    $query['statement'] = 'INSERT INTO votes
                                           VALUES(
                                               0,
                                               :category,
                                               :item,
                                               :rating,
                                               :posted
                                           )';
                    $query['params'] = array(
                        'category' => $args[2],
                        'item' => (int) $args[3],
                        'rating' => $rating,
                        'posted' => date('Y-m-d H:i:s'),
                    );
                    break;

                # Non-existing
                default:
                    $query['statement'] = '';
                    $query['params'] = array();
            } // switch ($args)
            return $query;
        } // getQuery()
    }
