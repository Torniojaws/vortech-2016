<?php

    require_once('news-api.php');
    require_once('releases-api.php');
    require_once('shows-api.php');

    // TODO:
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
                    $result = new ReleasesAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                case 'shows':
                    $result = new ShowsAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                case 'photos':
                    $result = new PhotosAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                case 'members':
                    $result = new MembersAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                case 'videos':
                    $result = new VideosAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                case 'visitors':
                    $result = new VisitorsAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                case 'shopitems':
                    $result = new ShopAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                case 'guestbook':
                    $result = new GuestbookAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                default:
                    $this->sql = "";
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
