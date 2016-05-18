<?php

    session_start();
    require_once 'EditValue.php';

    /**
     * When Admin wants to edit a song's details inline, it sends a PUT request to the endpoint
     */
    class EditSong extends EditValue
    {
        private $release;

        public function __construct($postData, $root)
        {
            if ($this->authorized() == true) {
                require_once $root.'constants.php';
                list($column, $release, $id) = explode('-', $_POST['id']);

                $this->id = $id;
                $this->column = $column;
                $this->release = $release;
                $this->new_value = $postData['value'];

                // eg. PUT http://www.vortechmusic.com/api/v1/releases/CD001/songs/123
                $this->endpoint = SERVER_URL.'api/v1/releases/'.$release.'/songs/'.$id;
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
                'release' => $release,
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
