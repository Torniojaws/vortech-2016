<?php

    session_start();
    require_once 'AdminAddBase.php';

    /**
     * This is used to submit admin comments to the guestbook posts.
     */
    class AddGuestbookComment extends AdminAddBase
    {
        private $id;
        private $comment;
        private $postedDate;

        public function __construct($data)
        {
            date_default_timezone_set('Europe/Helsinki');
            $this->postedDate = date('Y-m-d H:i:s');
            $this->id = $data['id'];
            $this->comment = $data['comment'];
            $this->root = $data['root'];
            require_once $this->root.'constants.php';

            # /guestbook/123/comments
            $api = 'api/v1/guestbook/'.$this->id.'/comments';
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
            $data['id'] = $this->id;
            $data['comment'] = $this->comment;
            $data['posted'] = $this->postedDate;

            return $data;
        }
    }
