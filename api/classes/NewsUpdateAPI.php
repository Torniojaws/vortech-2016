<?php

    class NewsUpdateAPI
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
                # /news/123
                case isset($args[2]) and is_numeric($args[2]) and isset($data):
                    // Expected to create variables "id", "column" and "new_value"
                    parse_str($data);
                    // Table and Column names CANNOT be parametrized in PDO, so we'll use a switch
                    switch ($column) {
                        case 'title':
                            $query['statement'] = 'UPDATE news SET title = ';
                            break;
                        case 'contents':
                            $query['statement'] = 'UPDATE news SET contents = ';
                            break;
                        case 'tags':
                            $query['statement'] = 'UPDATE news SET tags = ';
                            break;
                        default:
                            break;
                    }
                    $query['statement'] .= ':new_value WHERE id = :id';
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
