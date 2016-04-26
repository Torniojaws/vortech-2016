<?php

    session_start();

    class UsersAPI
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
                # /users
                case isset($args[2]) == false and isset($filters) == false:
                    $query['statement'] = 'SELECT id, name FROM users';
                    $query['params'] = array();
                    break;

                # /users/:id
                case isset($args[2]) and is_numeric($args[2]) and isset($args[3]) == false:
                    $query['statement'] = 'SELECT id,
                                                  name,
                                           FROM users
                                           WHERE id = :id LIMIT 1';
                    $query['params'] = array('id' => (int) $args[2]);
                    break;

                # /users/:name
                case isset($args[2]) and is_numeric($args[2]) == false and isset($args[3]) == false:
                    $query['statement'] = 'SELECT users.id,
                                                  users.name,
                                                  users.username,
                                                  users.caption,
                                                  photos.date_taken,
                                                  photos.full,
                                                  photos.thumbnail
                                           FROM users
                                           LEFT JOIN photos
                                                ON photos.taken_by = users.name
                                           WHERE username = :username LIMIT 1';
                    $query['params'] = array('username' => $args[2]);
                    break;

                # /users/:id/photo
                case isset($args[2]) and is_numeric($args[2]) and isset($args[3])
                     and $args[3] == 'photo':
                    $query['statement'] = 'SELECT photo_id
                                           FROM users
                                           WHERE id = :id LIMIT 1';
                    $query['params'] = array('id' => (int) $args[2]);
                    break;

                # Show all - same as /users
                default:
                    $query['statement'] = 'SELECT id, name, photo_id FROM users';
                    $query['params'] = array();
            }

            return $query;
        } // getQuery()
    }
