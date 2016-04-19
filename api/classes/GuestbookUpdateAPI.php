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
                case isset($args[2]) and is_numeric($args[2]) and isset($data):
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
                default:
                    $query = '';
            }

            return $query;
        } // getQuery()
    }
