<?php

    class StarRating
    {
        private $category;
        private $target_id;
        private $votes;
        private $rating;
        private $max_rating;
        private $vote_count;
        private $root;

        public function __construct($params)
        {
            $this->root = $params['rootdir'];
            require_once $this->root.'constants.php';

            $this->category = $params['category'];
            $this->target_id = $params['id'];
            $this->votes = $this->getVotes();
            $this->rating = $this->votes['rating'];
            $this->max_rating = $this->votes['max_rating'];
            $this->vote_count = $this->votes['votes'];
        }

        public function display()
        {
            include $this->root.'apps/main/partials/rating.php';
        }

        private function getVotes()
        {
            $api = 'api/v1/votes/'.$this->category.'/'.$this->target_id;
            $vote_data = json_decode(file_get_contents(SERVER_URL.$api), true);

            return $vote_data[0];
        }
    }
