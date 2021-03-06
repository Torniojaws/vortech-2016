<?php

    class UsersUpdateAPI
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

        private function getQuery($args, $filters, $data)
        {
            switch ($args) {
                # /users/:username
                case isset($args[2]) and is_numeric($args[2]) == false and isset($data):
                    // Expected to create variables "display_name", "username", "caption", "new_password"
                    parse_str($data);
                    // Note to self - you CANNOT use the same named parameter twice in a query!
                    if (isset($display_name) && isset($username) && isset($caption)) {
                        $query['statement'] = 'UPDATE users
                                               SET name = :name,
                                                   username = :username,
                                                   caption = :caption';
                        $query['params'] = array(
                            'name' => $display_name,
                            'username' => $username,
                            'caption' => $caption,
                            'old_username' => $old_username,
                        );
                        if (isset($new_password)) {
                            $query['statement'] .= ', password = :password';
                            $query['params']['password'] = $new_password;
                        }
                        // If user changes current username, we need this. Otherwise it is equal to
                        // current username anyway.
                        $query['statement'] .= ' WHERE username = :old_username';
                    }
                    break;
                default:
                    $query = '';
            }

            return $query;
        } // getQuery()
    }
