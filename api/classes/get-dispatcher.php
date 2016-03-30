<?php

    require_once('news-api.php');

    // TODO:
    #require_once('releases-api.php');
    #require_once('shows-api.php');
    #require_once('photos-api.php');
    #require_once('members-api.php');
    #require_once('videos-api.php');
    #require_once('visitors-api.php');
    #require_once('shop-api.php');
    #require_once('guestbook-api.php');

    class GETDispatcher
    {
        private $sql;

        public function __construct($original_request, $filters) {
            // Remove empty elements
            $request = array_filter(explode('/', $original_request), 'strlen');
            $root = $request[1];
            switch($root) {
                case 'news':
                    $result = new NewsAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                case 'releases':
                    $sql = new ReleasesAPI($request);
                    break;
                case 'shows':
                    $sql = new ShowAPI($request);
                    break;
                case 'photos':
                    $sql = new PhotosAPI($request);
                    break;
                case 'members':
                    $sql = new MembersAPI($request);
                    break;
                case 'videos':
                    $sql = new VideosAPI($request);
                    break;
                case 'visitors':
                    $sql = new VisitorsAPI($request);
                    break;
                case 'shopitems':
                    $sql = new ShopAPI($request);
                    break;
                case 'guestbook':
                    $sql = new GuestbookAPI($request);
                    break;
            }
            $this->sql;
        }

        public function getStatement()
        {
            return $this->sql['statement'];
        }
        public function getParams()
        {
            return $this->sql['params'];
        }
    }
