<?php

    require_once 'NewsAPI.php';
    require_once 'ReleasesAPI.php';
    require_once 'ShowsAPI.php';
    require_once 'PhotosAPI.php';
    require_once 'VisitorCountAPI.php';
    require_once 'MembersAPI.php';
    require_once 'VideosAPI.php';
    require_once 'ShopAPI.php';

    // TODO:
    #require_once 'GuestbookAPI.php';

    class GETDispatcher
    {
        private $sql;

        public function __construct($original_request, $filters)
        {
            // Remove empty elements
            $request = array_filter(explode('/', $original_request), 'strlen');
            $root = $request[1];
            switch ($root) {
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
                    $result = new VisitorCountAPI($request);
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
                    $this->sql = '';
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
