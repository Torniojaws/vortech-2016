<?php

    class UsersUpdateAPI
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
                # /users/:username
                case isset($args[2]) and is_numeric($args[2]) == false and isset($data):
                    echo 'Keissi';
                    // Expected to create variables "display_name", "username", "caption", "new_password"
                    parse_str($data);
                    if (isset($display_name) && isset($username) && isset($caption)) {
                        $query['statement'] = 'UPDATE users
                                               SET name = :name,
                                                   username = :username,
                                                   caption = :caption';
                        if (isset($new_password)) {
                            $query['statement'] .= ', password = :password';
                        }
                        $query['statement'] .= ' WHERE username = :username';
                        $query['params'] = array(
                            'name' => $display_name,
                            'username' => $username,
                            'caption' => $caption,
                        );
                        if (isset($new_password)) {
                            $query['params']['password'] = $new_password;
                        }
                    } else {
                        $query = '';
                    }
                    break;
                default:
                    $query = '';
            }

            return $query;
        } // getQuery()
    }
