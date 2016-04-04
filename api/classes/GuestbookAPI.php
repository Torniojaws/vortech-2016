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
            switch ($args) {
                # /guestbook-posts
                case isset($args[2]) == false and isset($filters) == false:
                    $query['statement'] = 'SELECT guestbook.*,
                                                  users.id AS userid,
                                                  users.photo_id,
                                                  users.name AS username,
                                                  guestbook_comments.author_id AS admin_id,
                                                  guestbook_comments.comment AS admin_comment,
                                                  guestbook_comments.posted AS admin_comment_date
                                           FROM guestbook
                                           LEFT JOIN users
                                                ON users.id = guestbook.poster_id
                                           LEFT JOIN guestbook_comments
                                                ON guestbook_comments.comment_subid = guestbook.id
                                           ORDER BY guestbook.posted DESC';
                    $query['params'] = array();
                    break;

                # /guestbook-posts?year=2015
                case isset($args[2]) == false and isset($filters):
                    // Expected parse_str variables are "year" and optionally "month"
                    parse_str($filters);
                    $query['statement'] = 'SELECT guestbook.*,
                                                  users.id AS userid,
                                                  users.photo_id,
                                                  users.name AS username,
                                                  guestbook_comments.author_id AS admin_id,
                                                  guestbook_comments.comment AS admin_comment,
                                                  guestbook_comments.posted AS admin_comment_date
                                           FROM guestbook
                                           LEFT JOIN users
                                                ON users.id = guestbook.poster_id
                                           LEFT JOIN guestbook_comments
                                                ON guestbook_comments.comment_subid = guestbook.id
                                           WHERE YEAR(guestbook.posted) = :year';
                    $query['params'] = array('year' => (int) $year);
                    if (isset($month)) {
                        $query['statement'] .= ' AND MONTH(posted) = :month';
                        $query['params']['month'] = (int) $month;
                    }
                    $query['statement'] .= ' ORDER BY guestbook.posted DESC';
                    break;

                # /guestbook-posts/:id
                case isset($args[2]) and isset($args[3]) == false:
                    $query['statement'] = 'SELECT guestbook.*,
                                                  users.id AS userid,
                                                  users.photo_id,
                                                  users.name AS username,
                                                  guestbook_comments.author_id AS admin_id,
                                                  guestbook_comments.comment AS admin_comment,
                                                  guestbook_comments.posted AS admin_comment_date
                                           FROM guestbook
                                           LEFT JOIN users
                                                ON users.id = guestbook.poster_id
                                           LEFT JOIN guestbook_comments
                                                ON guestbook_comments.comment_subid = guestbook.id
                                           WHERE guestbook.id = :id
                                           LIMIT 1';
                    $query['params'] = array('id' => (int) $args[2]);
                    break;

                # Show all - same as /guestbook-posts
                default:
                    $query['statement'] = 'SELECT * FROM guestbook ORDER BY posted DESC';
                    $query['params'] = array();
            }

            return $query;
        } // getQuery()
    }
