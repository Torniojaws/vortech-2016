<?php

    class PUTDispatcher
    {
        private $sql;

        public function __construct($original_request, $filters, $inputData)
        {
            // Remove empty elements
            $request = array_filter(explode('/', $original_request), 'strlen');
            $root = $request[1];
            switch ($root) {
                case 'visitors':
                    require_once 'VisitorUpdateAPI.php';
                    $result = new VisitorUpdateAPI($request, $inputData);
                    $this->sql = $result->getResult();
                    break;
                case 'news':
                    require_once 'NewsUpdateAPI.php';
                    $result = new NewsUpdateAPI($request, $inputData);
                    $this->sql = $result->getResult();
                    break;
                case 'guestbook':
                    require_once 'GuestbookUpdateAPI.php';
                    $result = new GuestbookUpdateAPI($request, $inputData);
                    $this->sql = $result->getResult();
                    break;
                case 'shopitems':
                    require_once 'ShopUpdateAPI.php';
                    $result = new ShopUpdateAPI($request, $inputData);
                    $this->sql = $result->getResult();
                    break;
                case 'videos':
                    require_once 'VideosUpdateAPI.php';
                    $result = new VideosUpdateAPI($request, $inputData);
                    $this->sql = $result->getResult();
                    break;
                case 'articles':
                    require_once 'ArticlesUpdateAPI.php';
                    $result = new ArticlesUpdateAPI($request, $filters, $inputData);
                    $this->sql = $result->getResult();
                    break;
                case 'shows':
                    require_once 'ShowsUpdateAPI.php';
                    $result = new ShowsUpdateAPI($request, $filters, $inputData);
                    $this->sql = $result->getResult();
                    break;
                case 'releases':
                    require_once 'ReleasesUpdateAPI.php';
                    $result = new ReleasesUpdateAPI($request, $filters, $inputData);
                    $this->sql = $result->getResult();
                    break;
                case 'photos':
                    require_once 'PhotosUpdateAPI.php';
                    $result = new PhotosUpdateAPI($request, $filters, $inputData);
                    $this->sql = $result->getResult();
                    break;
                case 'users':
                    require_once 'UsersUpdateAPI.php';
                    $result = new UsersUpdateAPI($request, $filters, $inputData);
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
