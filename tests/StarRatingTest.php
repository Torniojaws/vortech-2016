<?php

    require_once 'constants.php';

    class StarRatingTest extends PHPUnit_Framework_TestCase
    {
        public function testCanAccessVoteData()
        {
            $api = 'api/v1/votes/releases/1';
            $vote_data = json_decode(file_get_contents(SERVER_URL.$api), true);

            $this->assertEquals(1, $vote_data[0]['item']);
        }

        public function testRatingIsAValidNumber()
        {
            $song_api = 'api/v1/votes/songs/1';
            $song_vote_data = json_decode(file_get_contents(SERVER_URL.$song_api), true);

            $this->assertEquals(true, is_numeric($song_vote_data[0]['rating']));
        }

        public function testPhotosHasAValidValue()
        {
            $photo_api = 'api/v1/votes/photos/2';
            $photo_vote_data = json_decode(file_get_contents(SERVER_URL.$photo_api), true);

            $this->assertEquals(true, is_numeric($photo_vote_data[0]['max_rating']));
        }
    }
