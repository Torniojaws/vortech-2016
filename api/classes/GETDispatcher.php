<?php

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
                    require_once 'NewsAPI.php';
                    $result = new NewsAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                case 'releases':
                    require_once 'ReleasesAPI.php';
                    $result = new ReleasesAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                case 'shows':
                    require_once 'ShowsAPI.php';
                    $result = new ShowsAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                case 'photos':
                    require_once 'PhotosAPI.php';
                    $result = new PhotosAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                case 'members':
                    require_once 'MembersAPI.php';
                    $result = new MembersAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                case 'videos':
                    require_once 'VideosAPI.php';
                    $result = new VideosAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                case 'visitors':
                    require_once 'VisitorCountAPI.php';
                    $result = new VisitorCountAPI($request);
                    $this->sql = $result->getResult();
                    break;
                case 'shopitems':
                    require_once 'ShopAPI.php';
                    $result = new ShopAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                case 'guestbook':
                    require_once 'GuestbookAPI.php';
                    $result = new GuestbookAPI($request, $filters);
                    $this->sql = $result->getResult();
                    break;
                case 'users':
                    require_once 'UsersAPI.php';
                    $result = new UsersAPI($request, $filters);
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
