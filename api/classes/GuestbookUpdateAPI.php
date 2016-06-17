<?php

    class GuestbookUpdateAPI
    {
        public $result;

        public function __construct($request, $data)
        {
            $this->result = $this->getQuery($request, $data);
        }

        public function getResult()
        {
            return $this->result;
        }

        private function getQuery($args, $data)
        {
            switch ($args) {

                # /guestbook/123
                case isset($args[2]) and is_numeric($args[2]) and isset($args[3]) == false
                     and isset($data):
                    // Expected to create variables "id" and "new_value"
                    parse_str($data);
                    $query['statement'] = 'UPDATE guestbook_comments
                                           SET comment = :new_value
                                           WHERE comment_subid = :id';
                    $query['params'] = array(
                        'id' => (int) $args[2],
                        'new_value' => $new_value,
                    );
                    break;

                # /guestbook/123/comments
                case isset($args[2]) and is_numeric($args[2]) and isset($args[3])
                     and $args[3] == 'comments' and isset($data):
                    // Admin wants to add a comment to a given guestbook post
                    parse_str($data); // id, comment, posted
                    $query['statement'] = 'INSERT INTO guestbook_comments
                                           VALUES(
                                               0,
                                               :id,
                                               1,
                                               :comment,
                                               :posted
                                           )';
                    $query['params'] = array(
                        'id' => (int) $args[2],
                        'comment' => $comment,
                        'posted' => $posted,
                    );
                    break;
                default:
                    $query = '';
            }

            return $query;
        } // getQuery()
    }
