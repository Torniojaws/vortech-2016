<?php

    class ShowsUpdateAPI
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
                # /shows/123
                case isset($args[2]) and is_numeric($args[2]) and isset($data):
                    // Expected to create a whole bunch of variables
                    parse_str($data);
                    // Table and Column names CANNOT be parametrized in PDO, so we'll use a switch
                    $query['statement'] = 'UPDATE shows
                                           SET
                                                show_date = :show_date,
                                                continent = :continent,
                                                country = :country,
                                                city = :city,
                                                venue = :venue,
                                                other_bands = :other_bands,
                                                band_comments = :band_comments,
                                                setlist = :setlist,
                                                performers = :performers
                                          WHERE id = :id';
                    $query['params'] = array(
                        'id' => (int) $args[2],
                        'show_date' => $date,
                        'continent' => $continent,
                        'country' => $country,
                        'city' => $city,
                        'venue' => $venue,
                        'other_bands' => $other_bands,
                        'band_comments' => $band_comments,
                        'setlist' => $setlist,
                        'performers' => $performers,
                    );
                    break;
                default:
                    $query = '';
            }

            return $query;
        } // getQuery()
    }
