<?php

    class VideosUpdateAPI
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
            var_dump($data);
            switch ($args) {
                # /videos/123
                case isset($args[2]) and is_numeric($args[2]) and isset($data):
                    // Expected to create variables "id", "column" and "new_value"
                    parse_str($data);
                    // Table and Column names CANNOT be parametrized in PDO, so we'll use a switch
                    switch ($column) {
                        case 'videotitle':
                            $query['statement'] = 'UPDATE videos SET title = ';
                            break;
                        case 'videodura':
                            $query['statement'] = 'UPDATE videos SET duration = ';
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
