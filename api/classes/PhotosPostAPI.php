<?php

    class PhotosPostAPI
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

        private function getQuery($args, $filters = null, $data)
        {
            switch ($args) {

                # /photos/add
                case isset($args[2]) and $args[2] == 'add' and isset($args[3]) == false
                     and isset($filters) == false:
                    // Expecting to create multiple variables
                    parse_str($data);
                    $query['statement'] = 'INSERT INTO photos
                                           VALUES(
                                               0,
                                               :album_id,
                                               :date_taken,
                                               :taken_by,
                                               :full,
                                               :thumbnail,
                                               :caption
                                           )';
                    $query['params'] = array(
                        'album_id' => $album_id,
                        'date_taken' => $date,
                        'taken_by' => $taken_by,
                        'full' => $full,
                        'thumbnail' => $thumbnail,
                        'caption' => $caption,
                    );
                    break;

                # Non-existing
                default:
                    $query['statement'] = '';
                    $query['params'] = array();
            } // switch ($args)
            return $query;
        } // getQuery()
    }
