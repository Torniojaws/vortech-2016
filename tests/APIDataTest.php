<?php

    require_once 'constants.php';
    /**
     * Will test that each API endpoint returns expected data,
     * especially good for making sure all API changes still
     * return correct things.
     */
    class APIDataTest extends PHPUnit_Framework_TestCase
    {
        private $base_url;
        private $api_path;
        private $full_path;

        public function __construct()
        {
            $this->base_url = SERVER_URL;
            $this->api_path = 'api/v1/';
            $this->full_path = $this->base_url.$this->api_path;
        }

        public function testMembersAPIReturnsExpectedData()
        {
            # members
            $endpoint = 'members';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 1) {
                ++$missing;
            }
            if ($data[0]['name'] != 'Juha') {
                ++$missing;
            }
            if ($data[0]['type'] != 'Founding member') {
                ++$missing;
            }
            if ($data[0]['instrument'] != 'Guitar, Bass, Programming') {
                ++$missing;
            }
            if ($data[0]['started'] != '2000-01-01 00:00:00') {
                ++$missing;
            }
            if ($data[0]['quit'] != '9999-12-12 23:59:59') {
                ++$missing;
            }
            if ($data[0]['photo_id'] != 10) {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testGuestbookAPIReturnsExpectedData()
        {
            # guestbook
            $endpoint = 'guestbook';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if (is_numeric($data[0]['id']) == false) {
                ++$missing;
            }
            if (is_numeric($data[0]['poster_id']) == false) {
                ++$missing;
            }
            if (strlen($data[0]['name']) == 0) {
                ++$missing;
            }
            if (strlen($data[0]['post']) == 0) {
                ++$missing;
            }
            if (strtotime($data[0]['posted']) == false) {
                ++$missing;
            }
            if (is_numeric($data[0]['userid']) == false) {
                ++$missing;
            }
            if (strlen($data[0]['username']) == 0) {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testGuestbookYearFilterAPIReturnsExpectedData()
        {
            # guestbook?filter=value
            $endpoint = 'guestbook?year=2016';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if (is_numeric($data[0]['id']) == false) {
                ++$missing;
            }
            if (is_numeric($data[0]['poster_id']) == false) {
                ++$missing;
            }
            if (strlen($data[0]['name']) == 0) {
                ++$missing;
            }
            if (strlen($data[0]['post']) == 0) {
                ++$missing;
            }
            if (strtotime($data[0]['posted']) == false) {
                ++$missing;
            }
            if (is_numeric($data[0]['userid']) == false) {
                ++$missing;
            }
            if (strlen($data[0]['username']) == 0) {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testGuestbookYearMonthFilterAPIReturnsExpectedData()
        {
            # guestbook?filter=value&second=value
            $endpoint = 'guestbook?year=2016&amp;month=3';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if (is_numeric($data[0]['id']) == false) {
                ++$missing;
            }
            if (is_numeric($data[0]['poster_id']) == false) {
                ++$missing;
            }
            if (strlen($data[0]['name']) == 0) {
                ++$missing;
            }
            if (strlen($data[0]['post']) == 0) {
                ++$missing;
            }
            if (strtotime($data[0]['posted']) == false) {
                ++$missing;
            }
            if (is_numeric($data[0]['userid']) == false) {
                ++$missing;
            }
            if (strlen($data[0]['username']) == 0) {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testGuestbookSpecificPostAPIReturnsExpectedData()
        {
            # guestbook/:id
            $endpoint = 'guestbook/4';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 4) {
                ++$missing;
            }
            if ($data[0]['poster_id'] != 4) {
                ++$missing;
            }
            if ($data[0]['name'] != 'This is a blocked user') {
                ++$missing;
            }
            if ($data[0]['post'] != 'Did I perhaps post some spam?') {
                ++$missing;
            }
            if ($data[0]['posted'] != '2016-03-29 09:56:00') {
                ++$missing;
            }
            if ($data[0]['userid'] != 4) {
                ++$missing;
            }
            if ($data[0]['username'] != 'Blocked') {
                ++$missing;
            }
            if ($data[0]['admin_id'] != 1) {
                ++$missing;
            }
            if ($data[0]['admin_comment'] != 'Shame on maple leaf, eh') {
                ++$missing;
            }
            if ($data[0]['admin_comment_date'] != '2016-03-29 10:00:00') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testVisitorCountAPIReturnsExpectedData()
        {
            # visitors
            $endpoint = 'visitors';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if (is_numeric($data[0]['count']) == false) {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testNewsAPIReturnsExpectedData()
        {
            # news
            $endpoint = 'news';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if (is_numeric($data[0]['id']) == false) {
                ++$missing;
            }
            if (strlen($data[0]['title']) == 0) {
                ++$missing;
            }
            if (strlen($data[0]['contents']) == 0) {
                ++$missing;
            }
            if (strtotime($data[0]['posted']) == false) {
                ++$missing;
            }
            if (strlen($data[0]['author']) == 0) {
                ++$missing;
            }
            if (strlen($data[0]['tags']) == 0) {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testPhotosAPIReturnsExpectedData()
        {
            # photos
            $endpoint = 'photos';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 1) {
                ++$missing;
            }
            if ($data[0]['album_id'] != 4) {
                ++$missing;
            }
            if ($data[0]['date_taken'] != '2015-06-04 00:00:00') {
                ++$missing;
            }
            if ($data[0]['taken_by'] != 'Juha') {
                ++$missing;
            }
            if ($data[0]['full'] != 'image1.jpg') {
                ++$missing;
            }
            if ($data[0]['thumbnail'] != 'thumbnails/image1.jpg') {
                ++$missing;
            }
            if ($data[0]['caption'] != 'Live stuff 2') {
                ++$missing;
            }
            if ($data[0]['photo_album_id'] != 4) {
                ++$missing;
            }
            if ($data[0]['category_id'] != 3) {
                ++$missing;
            }
            if ($data[0]['show_in_gallery'] != 1) {
                ++$missing;
            }
            if ($data[0]['name_id'] != 'live') {
                ++$missing;
            }
            if ($data[0]['name'] != 'Live') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testMemberPhotosAPIReturnsExpectedData()
        {
            # photos/:id
            $endpoint = 'photos/1';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 1) {
                ++$missing;
            }
            if ($data[0]['album_id'] != 4) {
                ++$missing;
            }
            if ($data[0]['date_taken'] != '2015-06-04 00:00:00') {
                ++$missing;
            }
            if ($data[0]['taken_by'] != 'Juha') {
                ++$missing;
            }
            if ($data[0]['full'] != 'image1.jpg') {
                ++$missing;
            }
            if ($data[0]['thumbnail'] != 'thumbnails/image1.jpg') {
                ++$missing;
            }
            if ($data[0]['caption'] != 'Live stuff 2') {
                ++$missing;
            }
            if ($data[0]['photo_album_id'] != 4) {
                ++$missing;
            }
            if ($data[0]['category_id'] != 3) {
                ++$missing;
            }
            if ($data[0]['show_in_gallery'] != 1) {
                ++$missing;
            }
            if ($data[0]['name_id'] != 'live') {
                ++$missing;
            }
            if ($data[0]['name'] != 'Live') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testUserPhotosAPIReturnsExpectedData()
        {
            # photos/user-photos
            $endpoint = 'photos/user-photos';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 18) {
                ++$missing;
            }
            if ($data[0]['album_id'] != 7) {
                ++$missing;
            }
            if ($data[0]['date_taken'] != '2016-03-29 10:47:00') {
                ++$missing;
            }
            if ($data[0]['taken_by'] != 'Admin') {
                ++$missing;
            }
            if ($data[0]['full'] != 'admin.jpg') {
                ++$missing;
            }
            if ($data[0]['thumbnail'] != 'thumbnails/admin.jpg') {
                ++$missing;
            }
            if ($data[0]['caption'] != 'Administrator') {
                ++$missing;
            }
            if ($data[0]['photo_album_id'] != 7) {
                ++$missing;
            }
            if ($data[0]['category_id'] != 6) {
                ++$missing;
            }
            if ($data[0]['show_in_gallery'] != 0) {
                ++$missing;
            }
            if ($data[0]['name_id'] != 'user_photos') {
                ++$missing;
            }
            if ($data[0]['name'] != 'User avatars') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testPhotosLiveAPIReturnsExpectedData()
        {
            # photos/live
            $endpoint = 'photos/live';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 1) {
                ++$missing;
            }
            if ($data[0]['album_id'] != 4) {
                ++$missing;
            }
            if ($data[0]['date_taken'] != '2015-06-04 00:00:00') {
                ++$missing;
            }
            if ($data[0]['taken_by'] != 'Juha') {
                ++$missing;
            }
            if ($data[0]['full'] != 'image1.jpg') {
                ++$missing;
            }
            if ($data[0]['thumbnail'] != 'thumbnails/image1.jpg') {
                ++$missing;
            }
            if ($data[0]['caption'] != 'Live stuff 2') {
                ++$missing;
            }
            if ($data[0]['photo_album_id'] != 4) {
                ++$missing;
            }
            if ($data[0]['category_id'] != 3) {
                ++$missing;
            }
            if ($data[0]['show_in_gallery'] != 1) {
                ++$missing;
            }
            if ($data[0]['name_id'] != 'live') {
                ++$missing;
            }
            if ($data[0]['name'] != 'Live') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testPhotosMiscAPIReturnsExpectedData()
        {
            # photos/misc
            $endpoint = 'photos/misc';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 8) {
                ++$missing;
            }
            if ($data[0]['album_id'] != 5) {
                ++$missing;
            }
            if ($data[0]['date_taken'] != '2014-01-12 00:00:00') {
                ++$missing;
            }
            if ($data[0]['taken_by'] != 'Juha') {
                ++$missing;
            }
            if ($data[0]['full'] != 'image8.jpg') {
                ++$missing;
            }
            if ($data[0]['thumbnail'] != 'thumbnails/image8.jpg') {
                ++$missing;
            }
            if ($data[0]['caption'] != 'Strange pic') {
                ++$missing;
            }
            if ($data[0]['photo_album_id'] != 5) {
                ++$missing;
            }
            if ($data[0]['category_id'] != 4) {
                ++$missing;
            }
            if ($data[0]['show_in_gallery'] != 1) {
                ++$missing;
            }
            if ($data[0]['name_id'] != 'misc') {
                ++$missing;
            }
            if ($data[0]['name'] != 'Misc') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testPhotosPromoAPIReturnsExpectedData()
        {
            # photos/promo
            $endpoint = 'photos/promo';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 4) {
                ++$missing;
            }
            if ($data[0]['album_id'] != 1) {
                ++$missing;
            }
            if ($data[0]['date_taken'] != '2016-04-12 00:00:00') {
                ++$missing;
            }
            if ($data[0]['taken_by'] != 'Juha') {
                ++$missing;
            }
            if ($data[0]['full'] != 'image4.jpg') {
                ++$missing;
            }
            if ($data[0]['thumbnail'] != 'thumbnails/image4.jpg') {
                ++$missing;
            }
            if ($data[0]['caption'] != 'New promo pic!') {
                ++$missing;
            }
            if ($data[0]['photo_album_id'] != 1) {
                ++$missing;
            }
            if ($data[0]['category_id'] != 1) {
                ++$missing;
            }
            if ($data[0]['show_in_gallery'] != 1) {
                ++$missing;
            }
            if ($data[0]['name_id'] != 'promo') {
                ++$missing;
            }
            if ($data[0]['name'] != 'Promotional') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testPhotosStudioAPIReturnsExpectedData()
        {
            # photos/studio
            $endpoint = 'photos/studio';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 6) {
                ++$missing;
            }
            if ($data[0]['album_id'] != 3) {
                ++$missing;
            }
            if ($data[0]['date_taken'] != '2016-03-22 00:00:00') {
                ++$missing;
            }
            if ($data[0]['taken_by'] != 'Juha') {
                ++$missing;
            }
            if ($data[0]['full'] != 'image6.jpg') {
                ++$missing;
            }
            if ($data[0]['thumbnail'] != 'thumbnails/image6.jpg') {
                ++$missing;
            }
            if ($data[0]['caption'] != 'Latest work in the studio!') {
                ++$missing;
            }
            if ($data[0]['photo_album_id'] != 3) {
                ++$missing;
            }
            if ($data[0]['category_id'] != 2) {
                ++$missing;
            }
            if ($data[0]['show_in_gallery'] != 1) {
                ++$missing;
            }
            if ($data[0]['name_id'] != 'studio') {
                ++$missing;
            }
            if ($data[0]['name'] != 'Studio') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testReleasesAPIReturnsExpectedData()
        {
            # releases
            $endpoint = 'releases/CD006';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 20) {
                ++$missing;
            }
            if ($data[0]['title'] != 'Test Album 6') {
                ++$missing;
            }
            if ($data[0]['release_code'] != 'CD006') {
                ++$missing;
            }
            if ($data[0]['release_date'] != '2016-04-08 14:43:00') {
                ++$missing;
            }
            if ($data[0]['artist'] != 'Testiband') {
                ++$missing;
            }
            if ($data[0]['has_cd'] != 'yes') {
                ++$missing;
            }
            if ($data[0]['publish_date'] != '2015-01-01 00:00:00') {
                ++$missing;
            }
            if ($data[0]['full'] != 'cd.jpg') {
                ++$missing;
            }
            if ($data[0]['thumbnail'] != 'thumbnails/cd.jpg') {
                ++$missing;
            }
            if ($data[0]['release_notes'] != 'Release is done for this album from DB') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testSpecificReleaseAPIReturnsExpectedData()
        {
            # releases/:release_code
            $endpoint = 'releases/CD003';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 3) {
                ++$missing;
            }
            if ($data[0]['title'] != 'Album 3: Resurrection') {
                ++$missing;
            }
            if ($data[0]['release_code'] != 'CD003') {
                ++$missing;
            }
            if ($data[0]['release_date'] != '2014-04-05 00:00:00') {
                ++$missing;
            }
            if ($data[0]['artist'] != 'Artiste') {
                ++$missing;
            }
            if ($data[0]['has_cd'] != 'yes') {
                ++$missing;
            }
            if ($data[0]['publish_date'] != '2014-04-05 00:00:00') {
                ++$missing;
            }
            if ($data[0]['full'] != 'cd.jpg') {
                ++$missing;
            }
            if ($data[0]['thumbnail'] != 'thumbnails/cd.jpg') {
                ++$missing;
            }
            if ($data[0]['release_notes'] != 'Release notes for this album from DB') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testSpecificReleasesSongsAPIReturnsExpectedData()
        {
            # releases/:release_code/songs
            $endpoint = 'releases/CD003/songs';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['song_id'] != 4) {
                ++$missing;
            }
            if ($data[0]['release_code'] != 'CD003') {
                ++$missing;
            }
            if ($data[0]['release_song_id'] != 1) {
                ++$missing;
            }
            if ($data[0]['title'] != 'Triple trouble') {
                ++$missing;
            }
            if ($data[0]['duration'] != '00:04:26') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testSpecificReleasesSpecificSongAPIReturnsExpectedData()
        {
            # releases/:release_code/songs/:id
            $endpoint = 'releases/CD002/songs/1';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['song_id'] != 1) {
                ++$missing;
            }
            if ($data[0]['release_code'] != 'CD002') {
                ++$missing;
            }
            if ($data[0]['release_song_id'] != 1) {
                ++$missing;
            }
            if ($data[0]['title'] != 'Album 2: The Return') {
                ++$missing;
            }
            if ($data[0]['duration'] != '00:03:16') {
                ++$missing;
            }
            if ($data[0]['id'] != 2) {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testSpecificReleasesCommentsAPIReturnsExpectedData()
        {
            # releases/:release_code/comments
            $endpoint = 'releases/CD003/comments';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 6) {
                ++$missing;
            }
            if ($data[0]['comment_subid'] != 1) {
                ++$missing;
            }
            if ($data[0]['release_code'] != 'CD003') {
                ++$missing;
            }
            if ($data[0]['author'] != 'Testimies') {
                ++$missing;
            }
            if ($data[0]['comment'] != 'Nice album!') {
                ++$missing;
            }
            if ($data[0]['posted'] != '2016-04-03 22:55:00') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testSpecificReleasesSoecificCommentAPIReturnsExpectedData()
        {
            # releases/:release_code/comments/1
            $endpoint = 'releases/CD003/comments/1';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 6) {
                ++$missing;
            }
            if ($data[0]['comment_subid'] != 1) {
                ++$missing;
            }
            if ($data[0]['release_code'] != 'CD003') {
                ++$missing;
            }
            if ($data[0]['author'] != 'Testimies') {
                ++$missing;
            }
            if ($data[0]['comment'] != 'Nice album!') {
                ++$missing;
            }
            if ($data[0]['posted'] != '2016-04-03 22:55:00') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testSpecificReleasesSoecificSongsCommentsAPIReturnsExpectedData()
        {
            # releases/:release_code/songs/:id/comments
            $endpoint = 'releases/CD003/songs/1/comments';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 1) {
                ++$missing;
            }
            if ($data[0]['song_id'] != 1) {
                ++$missing;
            }
            if ($data[0]['comment_subid'] != 1) {
                ++$missing;
            }
            if ($data[0]['author'] != 'Jepss') {
                ++$missing;
            }
            if ($data[0]['author_id'] != 3) {
                ++$missing;
            }
            if ($data[0]['comment'] != 'Very nice song this one!') {
                ++$missing;
            }
            if ($data[0]['posted'] != '2016-03-31 15:16:00') {
                ++$missing;
            }
            if ($data[0]['title'] != 'Album 3: Resurrection') {
                ++$missing;
            }
            if ($data[0]['release_date'] != '2014-04-05 00:00:00') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testSpecificReleasesSoecificSongsSpecificCommentAPIReturnsExpectedData()
        {
            # releases/:release_code/songs/:id/comments/:id
            $endpoint = 'releases/CD003/songs/1/comments/1';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 1) {
                ++$missing;
            }
            if ($data[0]['song_id'] != 1) {
                ++$missing;
            }
            if ($data[0]['comment_subid'] != 1) {
                ++$missing;
            }
            if ($data[0]['author'] != 'Jepss') {
                ++$missing;
            }
            if ($data[0]['author_id'] != 3) {
                ++$missing;
            }
            if ($data[0]['comment'] != 'Very nice song this one!') {
                ++$missing;
            }
            if ($data[0]['posted'] != '2016-03-31 15:16:00') {
                ++$missing;
            }
            if ($data[0]['title'] != 'Album 3: Resurrection') {
                ++$missing;
            }
            if ($data[0]['release_date'] != '2014-04-05 00:00:00') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testShopAPIReturnsExpectedData()
        {
            # shopitems
            $endpoint = 'shopitems';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 1) {
                ++$missing;
            }
            if ($data[0]['category_id'] != 1) {
                ++$missing;
            }
            if ($data[0]['name'] != 'T-shirt 2009') {
                ++$missing;
            }
            if ($data[0]['album_id'] != 0) {
                ++$missing;
            }
            if ($data[0]['description'] != 'Very nice thingy!') {
                ++$missing;
            }
            if ($data[0]['price'] != 123.45) {
                ++$missing;
            }
            if ($data[0]['full'] != 'shop-shirt2009.jpg') {
                ++$missing;
            }
            if ($data[0]['thumbnail'] != 'thumbnails/shop-shirt2009.jpg') {
                ++$missing;
            }
            if ($data[0]['paypal_button'] != 'PayBal button') {
                ++$missing;
            }
            if ($data[0]['paypal_link'] != 'http://www.paypal.com') {
                ++$missing;
            }
            if ($data[0]['bandcamp_link'] != 'http://vortech.bandcamp.com') {
                ++$missing;
            }
            if ($data[0]['amazon_link'] != 'http://www.amazon.com') {
                ++$missing;
            }
            if ($data[0]['spotify_link'] != 'http://www.spotify.com') {
                ++$missing;
            }
            if ($data[0]['deezer_link'] != 'http://www.deezer.com') {
                ++$missing;
            }
            if ($data[0]['itunes_link'] != 'http://www.itunes.com') {
                ++$missing;
            }
            if ($data[0]['name_id'] != 'merch') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testShowsAPIReturnsExpectedData()
        {
            # shows
            $endpoint = 'shows';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 1) {
                ++$missing;
            }
            if ($data[0]['show_date'] != '2015-03-03 00:00:00') {
                ++$missing;
            }
            if ($data[0]['continent'] != 'Europe') {
                ++$missing;
            }
            if ($data[0]['country'] != 'Finland') {
                ++$missing;
            }
            if ($data[0]['city'] != 'Tornio') {
                ++$missing;
            }
            if ($data[0]['venue'] != 'Pikisaari') {
                ++$missing;
            }
            if ($data[0]['other_bands'] != 'Joku|www.testi.fi, Toinen|www.bandi.fi') {
                ++$missing;
            }
            if ($data[0]['band_comments'] != 'Nice show test 2') {
                ++$missing;
            }
            if ($data[0]['setlist'] != 'Eka|Toka|Kolmas') {
                ++$missing;
            }
            if ($data[0]['performers'] != 'Juha|Gtr, Mikko|Vox, Ville|Drums') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }

        public function testVideosAPIReturnsExpectedData()
        {
            # videos
            $endpoint = 'videos';
            $get = file_get_contents($this->full_path.$endpoint);
            $data = json_decode($get, true);

            // Expected values
            $missing = 0;
            if ($data[0]['id'] != 1) {
                ++$missing;
            }
            if ($data[0]['title'] != 'The Live in Oulu') {
                ++$missing;
            }
            if ($data[0]['url'] != 'http://www.vimeo.com/vortech') {
                ++$missing;
            }
            if ($data[0]['host'] != 'Vimeo') {
                ++$missing;
            }
            if ($data[0]['duration'] != '00:25:00') {
                ++$missing;
            }
            if ($data[0]['thumbnail'] != 'videos/thumbnails/oulu2009.jpg') {
                ++$missing;
            }
            if ($data[0]['category_id'] != 1) {
                ++$missing;
            }
            if ($data[0]['name'] != 'Live') {
                ++$missing;
            }
            if ($data[0]['description'] != 'Videos from our live performances') {
                ++$missing;
            }

            $this->assertEquals(0, $missing);
        }
    }
