<?php

    session_start();
    require_once 'EditValue.php';

    /**
     * When Admin wants to edit a show's details inline, it sends a PUT request to the endpoint.
     */
    class EditShow extends EditValue
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

        public function __construct($postData, $root)
        {
            if ($this->authorized() == true) {
                require_once $root.'constants.php';
                $this->id = $postData['id'];
                $this->date = $postData['date'];
                $this->continent = $postData['continent'];
                $this->country = $postData['country'];
                $this->city = $postData['city'];
                $this->venue = $postData['venue'];
                $this->other_bands = $postData['bands'];
                $this->band_comments = $postData['band-comments'];
                $this->setlist = $postData['setlist'];
                $this->performers = $postData['performers'];

                // eg. PUT http://www.vortechmusic.com/api/v1/releases/CD001/songs/123
                $this->endpoint = SERVER_URL.'api/v1/shows/'.$this->id;
                $this->payload = $this->buildRequest();
            } else {
                header('HTTP/1.1 401 Unauthorized');
                exit;
            }
        }

        /**
         * Create the PUT request to be sent to API.
         *
         * @return $payload The request context to be used in the PUT request
         */
        private function buildRequest()
        {
            $data = array(
                'id' => $this->id,
                'date' => $this->date,
                'continent' => $this->continent,
                'country' => $this->country,
                'city' => $this->city,
                'venue' => $this->venue,
                'other_bands' => $this->other_bands,
                'band_comments' => $this->band_comments,
                'setlist' => $this->setlist,
                'performers' => $this->performers,
            );
            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'PUT',
                    'content' => http_build_query($data),
                ),
            );

            return stream_context_create($options);
        }
    }
