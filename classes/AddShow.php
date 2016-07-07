<?php

    session_start();
    require_once 'AdminAddBase.php';

    class AddShow extends AdminAddBase
    {
        private $date;
        private $continent;
        private $country;
        private $city;
        private $venue;
        private $other_bands;
        private $band_comments;
        private $setlist;
        private $performers;

        public function __construct($data)
        {
            $this->root = $data['root'];
            $this->date = $data['date'];
            $this->continent = $data['continent'];
            $this->country = $data['country'];
            $this->city = $data['city'];
            $this->venue = $data['venue'];
            $this->other_bands = $data['other_bands'];
            $this->band_comments = $data['band_comments'];
            $this->setlist = $data['setlist'];
            $this->performers = $data['performers'];

            # /shows
            require_once $this->root.'constants.php';
            $api = 'api/v1/shows';
            $this->endpoint = SERVER_URL.$api;
            $this->payload = $this->buildRequest($this->buildDataArray());
        }

        /**
         * Create the class-specific data array that will be sent as payload to the API.
         *
         * @return $array The data to be sent.
         */
        private function buildDataArray()
        {
            $data['date'] = $this->date;
            $data['continent'] = $this->continent;
            $data['country'] = $this->country;
            $data['city'] = $this->city;
            $data['venue'] = $this->venue;
            // Optional, will be null if no value
            $data['other_bands'] = $this->other_bands;
            $data['band_comments'] = $this->band_comments;
            $data['setlist'] = $this->setlist;
            $data['performers'] = $this->performers;

            return $data;
        }
    }
