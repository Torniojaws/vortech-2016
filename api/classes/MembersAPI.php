<?php

    class MembersAPI
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
                # /members
                case isset($args[2]) == false and isset($filters) == false:
                    $query['statement'] = 'SELECT * FROM performers';
                    $query['params'] = array();
                    break;

                # /members?active=yes
                case isset($args[2]) == false and isset($filters):
                    parse_str($filters);
                    // Active / Previous members
                    if (isset($active) and strtolower($active) == 'yes') {
                        $query['statement'] = 'SELECT * FROM performers WHERE YEAR(quit) = 9999';
                        $query['params'] = array();
                    } elseif (isset($active) and strtolower($active) == 'no') {
                        $query['statement'] = 'SELECT * FROM performers WHERE YEAR(quit) < 9999';
                        $query['params'] = array();
                    }
                    // Guest artists
                    elseif (isset($guest) and strtolower($guest) == 'yes') {
                        $query['statement'] = 'SELECT * FROM performers WHERE type LIKE "Guest%"';
                        $query['params'] = array();
                    } elseif (isset($guest) and strtolower($guest) == 'no') {
                        $query['statement'] = 'SELECT * FROM performers WHERE type NOT LIKE "Guest%"';
                        $query['params'] = array();
                    }
                    break;

                # /members/:id
                case isset($args[2]) and isset($args[3]) == false:
                    $query['statement'] = 'SELECT * FROM performers WHERE id = :id LIMIT 1';
                    $query['params'] = array('id' => (int) $args[2]);
                    break;

                # /members/:id/comments
                case isset($args[2]) and isset($args[3]) and $args[3] == 'comments' and isset($args[4]) == false:
                    $query['statement'] = 'SELECT * FROM performer_comments WHERE performer_id = :id';
                    $query['params'] = array('id' => (int) $args[2]);
                    break;

                # /members/:id/comments/:id
                case isset($args[2]) and isset($args[3]) and $args[3] == 'comments' and isset($args[4]):
                    $query['statement'] = 'SELECT *
                                           FROM performer_comments
                                           WHERE comment_subid = :id AND performer_id = :performer_id LIMIT 1';
                    $query['params'] = array('id' => (int) $args[4], 'performer_id' => (int) $args[2]);
                    break;

                # Show all - same as /releases
                default:
                    $query['statement'] = 'SELECT * FROM performers ORDER BY id DESC';
                    $query['params'] = array();
            }

            return $query;
        }
    }
