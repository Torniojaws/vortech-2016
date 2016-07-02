<?php

    /**
     * This is the base class for all Add features that admin can use, eg. Add Guestbook Comment,
     * Add Video, etc.
     */
    class AdminAddBase
    {
        protected $root;
        protected $payload;
        protected $endpoint;

        public function __construct($data)
        {
            $this->root = $data['root'];
        }

        /**
         * Send the current payload into the API, which will store it in the system.
         *
         * @return $response The JSON response
         */
        public function commit()
        {
            if ($this->authorized() == true) {
                $request = file_get_contents($this->endpoint, false, $this->payload);
                if ($request === false) {
                    $response['status'] = 'error';
                    $response['message'] = 'Could not update to DB';
                } else {
                    $response['status'] = 'success';
                    $response['message'] = 'Updated DB successfully';
                }
            } else {
                if (isset($_SESSION['authorized']) == false) {
                    header('HTTP/1.1 401 Unauthorized');
                    exit;
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Missing required data';
                }
            }

            return $response;
        }

        /**
         * Check that admin has logged in.
         *
         * @return $authorized The result of the logged in check
         */
        protected function authorized()
        {
            return $_SESSION['authorized'] == 1;
        }

        /**
         * Create the PUT request to be sent to API. The data for the request is created inside the
         * subclass of each specific case, and the data will vary quite a lot.
         *
         * @param $data An array containing the class-specific data to be sent to API
         *
         * @return $payload The request context to be used in the PUT request
         */
        protected function buildRequest($data)
        {
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
