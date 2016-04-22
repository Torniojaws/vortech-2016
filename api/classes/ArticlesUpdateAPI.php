<?php

    class ArticlesUpdateAPI
    {
        public $result;

        public function __construct($request, $filters, $data)
        {
            $this->result = $this->getQuery($request, $filters, $data);
        }

        public function getResult()
        {
            return $this->result;
        }

        private function getQuery($args, $filters = null, $data)
        {
            var_dump($filters);
            switch ($args) {
                # /articles/123
                case isset($args[2]) and is_numeric($args[2]) and isset($data):
                    // Expected to create variables "id" and "new_value"
                    parse_str($data);
                    // Table and Column names CANNOT be parametrized in PDO, so we'll use a switch
                    switch ($column) {
                        case 'biofull':
                            $query['statement'] = 'UPDATE articles SET full = ';
                            break;
                        case 'bioshort':
                            $query['statement'] = 'UPDATE articles SET short = ';
                            break;
                        case 'landingfull':
                            $query['statement'] = 'UPDATE articles SET full = ';
                            break;
                        case 'landingshort':
                            $query['statement'] = 'UPDATE articles SET short = ';
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
                # /articles?category=name&subid=123
                case isset($args[2]) == false and isset($filters) and isset($data):
                    // Expected to create variables "id" and "new_value"
                    parse_str($data);
                    // Expected to create variables "category" and "subid"
                    parse_str($filters);

                    // Table and Column names CANNOT be parametrized in PDO, so we'll use a switch
                    switch ($column) {
                        case 'memberfull':
                            $query['statement'] = 'UPDATE articles SET full = ';
                            break;
                        case 'membershort':
                            $query['statement'] = 'UPDATE articles SET short = ';
                            break;
                        default:
                            break;
                    }
                    $query['statement'] .= ':new_value WHERE subid = :subid AND category = :category';
                    $query['params'] = array(
                        'subid' => (int) $subid,
                        'category' => $category,
                        'new_value' => $new_value,
                    );
                    var_dump($query);
                    break;
                default:
                    $query = '';
            }

            return $query;
        } // getQuery()
    }
