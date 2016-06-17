<?php

    session_start();

    /**
     * This is used to submit admin comments to the guestbook posts
     */
    class AddGuestbookComment
    {
        private $id;
        private $comment;
        private $postedDate;
        private $endpoint;
        private $payload;
        private $root;

        public function __construct($data)
        {
            date_default_timezone_set('Europe/Helsinki');
            $this->id = $data['id'];
            $this->comment = $data['comment'];
            $this->postedDate = date('Y-m-d H:i:s');
            $this->root = $data['root'];
            require_once $this->root.'constants.php';

            # /guestbook/123/comments
            $api = 'api/v1/guestbook/'.$this->id.'/comments';
            $this->endpoint = SERVER_URL.$api;
            $this->payload = $this->buildRequest();
        }

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
        private function authorized()
        {
            return $_SESSION['authorized'] == 1;
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
                'comment' => $this->comment,
                'posted' => $this->postedDate,
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
