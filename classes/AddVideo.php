<?php

    session_start();
    require_once 'AdminAddBase.php';

    class AddVideo extends AdminAddBase
    {
        private $title;
        private $url;
        private $host;
        private $duration;
        private $category;
        private $thumbnail_files;
        private $thumbnail_relative_path;
        private $thumbnail_fullpath;
        private $thumbnail_location; // Relative path to file

        public function __construct($data)
        {
            $this->root = $data['root'];
            $this->title = $data['title'];
            $this->url = $data['url'];
            $this->host = $this->getHost();
            $this->duration = $data['duration'];
            $this->category = $data['category'];
            $this->thumbnail_files = $data['thumbnail'];

            // Video thumbnail processing
            $this->thumbnail_relative_path = 'videos/thumbnails/';
            $this->thumbnail_fullpath = $this->root.'/static/img/'.$this->thumbnail_relative_path;
            $this->storeVideoThumbnail();

            # /videos
            require_once $this->root.'constants.php';
            $api = 'api/v1/videos';
            $this->endpoint = SERVER_URL.$api;
            $this->payload = $this->buildRequest($this->buildDataArray());
        }

        /**
         * Get the host (eg. Youtube) of a video from the url.
         *
         * @return $host The host of the video
         */
        private function getHost()
        {
            $parsed = parse_url($this->url);
            $host = str_replace('.com', '', $parsed['host']);
            $host = str_replace('www.', '', $host);
            $host = ucfirst($host);

            return $host;
        }

        /**
         * Save the user-uploaded thumbnail for a video in the specified directory. We only expect
         * to receive one file.
         */
        private function storeVideoThumbnail()
        {
            foreach ($this->thumbnail as $file => $details)
            {
                $tmp = $details['tmp_name'];
                $target_filename = $details['name'];
                try {
                    move_uploaded_file($tmp, $this->thumbnail_fullpath.$target_filename);
                    $this->thumbnail_location = $this->thumbnail_relative_path.$target_filename;
                } catch (Exception $ex) {
                    exit('Could not upload thumbnail!');
                }
            }
        }

        /**
         * Create the class-specific data array that will be sent as payload to the API.
         *
         * @return $array The data to be sent.
         */
        private function buildDataArray()
        {
            $data['title'] = $this->title;
            $data['url'] = $this->url;
            $data['host'] = $this->host;
            $data['duration'] = $this->duration;
            $data['thumbnail'] = $this->thumbnail_location;
            $data['category'] = $this->category;

            return $data;
        }
    }
