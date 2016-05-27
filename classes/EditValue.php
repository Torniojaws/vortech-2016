<?php

    session_start();

    /**
     * When Admin wants to edit a specific value inline, it sends a PUT request to a given endpoint.
     */
    class EditValue
    {
        protected $id;
        protected $column;
        protected $new_value;
        protected $category;
        protected $endpoint;
        protected $payload;

        public function __construct($postData, $category, $root)
        {
            if ($this->authorized() == true) {
                require_once $root.'constants.php';
                list($column, $id) = explode('-', $postData['id']);

                $this->id = $id;
                $this->column = $column;
                $this->new_value = $postData['value'];
                // Category is eg. "videos" or "releases"
                // for clarity, we add the trailing slash here, but
                // only if the url does not contain parameters
                if (strpos($category, '?') === false) {
                    // No parameters in url, so we'll add a trailing slash
                    $category .= '/';
                }
                $this->category = $category;

                // eg. PUT http://www.vortechmusic.com/api/v1/videos/123
                $this->endpoint = SERVER_URL.'api/v1/'.$category.$id;
                $this->payload = $this->buildRequest();
            } else {
                header('HTTP/1.1 401 Unauthorized');
                exit;
            }
        }

        /**
         * Sends the request to API and builds a response message based on results.
         *
         * @return $response The results of the request in an array
         */
        public function commitEdit()
        {
            $request = file_get_contents($this->endpoint, false, $this->payload);
            if ($request === false) {
                $response['status'] = 'error';
                $response['message'] = 'Could not update to DB';
            } else {
                $response['status'] = 'success';
                $response['message'] = 'Updated DB successfully';
            }

            return $response;
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
                'column' => $this->column,
                'new_value' => $this->new_value,
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

        protected function authorized()
        {
            return isset($_SESSION) and $_SESSION['authorized'] == 1;
        }
    }
