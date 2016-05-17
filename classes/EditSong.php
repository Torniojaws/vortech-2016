<?php

    session_start();

    /**
     * When Admin wants to edit a song's details inline, it sends a PUT request to the endpoint
     */
    class EditSong extends EditValue
    {

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
         * Create the PUT request to be sent to API
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

    }
