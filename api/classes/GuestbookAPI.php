<?php

    class GuestbookAPI
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
            // All guestbook SQLs run the same base query, so we'll define it for all:
            $base_sql = 'SELECT guestbook.*,
                                users.id AS userid,
                                users.name AS username,
                                guestbook_comments.author_id AS admin_id,
                                guestbook_comments.comment AS admin_comment,
                                guestbook_comments.posted AS admin_comment_date
                        FROM guestbook
                        LEFT JOIN users
                             ON users.id = guestbook.poster_id
                        LEFT JOIN guestbook_comments
                             ON guestbook_comments.comment_subid = guestbook.id';

            switch ($args) {
                # /guestbook
                case isset($args[2]) == false:
                    $query['statement'] = $base_sql;
                    $query['params'] = array();

                    // Check for filters. Expecting optional "year" and "month"
                    if (isset($filters) == true) {
                        parse_str($filters);
                    }

                    # /guestbook?year=2015
                    if (isset($year)) {
                        $query['statement'] .= ' WHERE YEAR(guestbook.posted) = :year';
                        $query['params']['year'] = (int) $year;
                    }

                    # /guestbook?year=2015&month=3
                    if (isset($month)) {
                        $query['statement'] .= ' AND MONTH(guestbook.posted) = :month';
                        $query['params']['month'] = (int) $month;
                    }

                    $query['statement'] .= ' ORDER BY guestbook.posted DESC';
                    break;

                # /guestbook/:id
                case isset($args[2]) and isset($args[3]) == false:
                    $query['statement'] = $base_sql;
                    $query['statement'] .= ' WHERE guestbook.id = :id
                                           LIMIT 1';
                    $query['params'] = array('id' => (int) $args[2]);
                    break;

                # Show all - same as /guestbook
                default:
                    $query['statement'] = 'SELECT * FROM guestbook ORDER BY posted DESC';
                    $query['params'] = array();
            }

            return $query;
        } // getQuery()
    }
