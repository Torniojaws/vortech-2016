<?php

    class PhotosUpdateAPI
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
                # /photos/123
                case isset($args[2]) and is_numeric($args[2]) and isset($args[3]) == false
                     and isset($data):
                    // Expected to create variables "id", "column", and "new_value"
                    parse_str($data);
                    // Table and Column names CANNOT be parametrized in PDO, so we'll use a switch
                    switch ($column) {
                        case 'photocaption':
                            $query['statement'] = 'UPDATE photos SET caption = ';
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
