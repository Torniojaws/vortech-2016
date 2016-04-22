<?php

    class ReleasesUpdateAPI
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
                # /releases/CD001
                case isset($args[2]) and isset($args[3]) == false and isset($data):
                    // Expected to create variables "release_code", "column", and "new_value"
                    parse_str($data);
                    // Table and Column names CANNOT be parametrized in PDO, so we'll use a switch
                    switch ($column) {
                        case 'releasetitle':
                            $query['statement'] = 'UPDATE releases SET title = ';
                            break;
                        case 'releaseartist':
                            $query['statement'] = 'UPDATE releases SET artist = ';
                            break;
                        case 'releasedate':
                            $query['statement'] = 'UPDATE releases SET release_date = ';
                            break;
                        case 'releasecode':
                            $query['statement'] = 'UPDATE releases SET release_code = ';
                            break;
                        case 'releasenotes':
                            $query['statement'] = 'UPDATE releases SET release_notes = ';
                            break;
                        default:
                            break;
                    }
                    $query['statement'] .= ':new_value WHERE release_code = :release_code';
                    $query['params'] = array(
                        'release_code' => $args[2],
                        'new_value' => $new_value,
                    );
                    break;
                # /releases/CD003/songs/1
                case isset($args[2]) and isset($args[3]) and isset($args[4]) and is_numeric($args[4])
                     and isset($data):
                    // Expected to create variables "id", "release_code", "column", and "new_value"
                    parse_str($data);
                    switch ($column) {
                        case 'songtitle':
                            $query['statement'] = 'UPDATE songs SET title = ';
                            break;
                        case 'songdura':
                            $query['statement'] = 'UPDATE songs SET duration = ';
                            break;
                        default:
                            break;
                    }
                    $query['statement'] .= ':new_value WHERE release_code = :release_code
                                            AND release_song_id = :id';
                    $query['params'] = array(
                        'id' => (int) $args[4],
                        'release_code' => $args[2],
                        'new_value' => $new_value,
                    );
                    break;
                default:
                    $query = '';
            }

            return $query;
        } // getQuery()
    }
