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
            $base_sql = 'SELECT * FROM performers';

            switch ($args) {
                # /members
                case isset($args[2]) == false and isset($filters) == false:
                    $query['statement'] = $base_sql;
                    $query['params'] = array();
                    break;

                # /members?active=yes
                case isset($args[2]) == false and isset($filters):
                    parse_str($filters);
                    // Active / Previous members
                    if (isset($active) and strtolower($active) == 'yes') {
                        $query['statement'] = $base_sql.' WHERE YEAR(quit) = 9999';
                        $query['params'] = array();
                    } elseif (isset($active) and strtolower($active) == 'no') {
                        $query['statement'] = $base_sql.' WHERE YEAR(quit) < 9999';
                        $query['params'] = array();
                    }
                    // Guest artists
                    elseif (isset($guest) and strtolower($guest) == 'yes') {
                        $query['statement'] = $base_sql.' WHERE type LIKE "Guest%"';
                        $query['params'] = array();
                    } elseif (isset($guest) and strtolower($guest) == 'no') {
                        $query['statement'] = $base_sql.' WHERE type NOT LIKE "Guest%"';
                        $query['params'] = array();
                    }
                    break;

                # /members/:id
                case isset($args[2]) and isset($args[3]) == false:
                    $query['statement'] = $base_sql.' WHERE id = :id LIMIT 1';
                    $query['params'] = array('id' => (int) $args[2]);
                    break;

                # /members/:id/comments
                case isset($args[2]) and isset($args[3]) and $args[3] == 'comments':
                    $query['statement'] = 'SELECT * FROM performer_comments WHERE performer_id = :id';
                    $query['params'] = array('id' => (int) $args[2]);

                    # /members/:id/comments/:id
                    if (isset($args[4])) {
                        $query['statement'] .= ' AND comment_subid = :sub_id LIMIT 1';
                        $query['params']['sub_id'] = (int) $args[4];
                    }
                    break;

                # Show all - same as /releases
                default:
                    $query['statement'] = $base_sql.' ORDER BY id DESC';
                    $query['params'] = array();
            }

            return $query;
        }
    }
