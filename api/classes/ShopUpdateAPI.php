<?php

    class ShopUpdateAPI
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
                # /shopitems/123
                case isset($args[2]) and is_numeric($args[2]) and isset($data):
                    // Expected to create variables "id", "column", and "new_value"
                    parse_str($data);
                    // Table and Column names CANNOT be parametrized in PDO, so we'll use a switch
                    switch ($column) {
                        case 'shopname':
                            $query['statement'] = 'UPDATE shop_items SET name = ';
                            break;
                        case 'shopdesc':
                            $query['statement'] = 'UPDATE shop_items SET description = ';
                            break;
                        case 'shopprice':
                            $query['statement'] = 'UPDATE shop_items SET price = ';
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
