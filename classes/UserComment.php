<?php

    session_start();

    class UserComment
    {
        protected $user_id;
        protected $user_display_name;
        protected $category; // Eg. News comment, Shopitem comment, etc.
        protected $comment;
        protected $date_posted;
        // ID of item the comment is for. Normally an integer, but release_code for releases
        protected $comment_target_id;
        // The sub-id of a comment for a given ID,
        // eg. if "Photo 1" (id = 1) has 3 comments, the last sub-id is 3
        protected $comment_sub_id;
        // Photos and Shopitems also have categories (eg. "Live photos" or "Digital Albums")
        // and this is the ID. Otherwise this is null
        protected $category_comment_sub_id = null;
        protected $modal_id = null;
        protected $root;

        // For the SQL
        protected $statement;
        protected $parameters;

        public function __construct($params)
        {
            if ($this->authorized() == true) {
                $this->root = $params['root'];
                require_once $this->root.'constants.php';

                $this->date_posted = date('Y-m-d H:i:s');
                $this->user_id = $params['user_id'];
                $this->user_display_name = $params['display_name'];
                $this->category = $params['category'];
                $this->comment = $params['comment'];
                $this->comment_target_id = $params['comment_target_id'];
                if (isset($params['modal_id'])) {
                    $this->modal_id = $params['modal_id'];
                }
                $this->modal_id = $params['modal_id'];
                $this->comment_sub_id = $params['comment_subid'];
                if (isset($params['category_subid'])) {
                    $this->category_comment_sub_id = $params['category_subid'];
                }

                if ($this->checkStatus() == 'ok') {
                    $this->statement = $this->buildStatement();
                    $this->parameters = $this->buildParameters();
                }
            } else {
                header('HTTP/1.1 401 Unauthorized');
                exit;
            }
        }

        public function commitPost()
        {
            require_once $this->root.'api/classes/Database.php';
            $db = new Database();
            $db->connect();
            $db->run($this->statement, $this->parameters);
            $db->close();
            if ($db->querySuccessful() == true) {
                $response['status'] = 'success';
                $response['message'] = 'Comment added successfully';
                $response['modal_id'] = $this->modal_id; // Used to show correct status div
                if ($this->category == 'releases') {
                    $response['release_code'] = $this->comment_target_id;
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Could not update DB';
                $response['modal_id'] = $this->modal_id; // Used to show correct status div
            }

            header('Content-type: application/json');
            echo json_encode($response);
        }

        protected function authorized()
        {
            return isset($_SESSION['user_logged']) && $_SESSION['user_logged'] == 1;
        }

        protected function checkStatus()
        {
            if (isset($this->comment) == false or isset($this->user_id) == false) {
                $response['status'] = 'error';
                $response['message'] = 'Missing required data';
                $response['modal_id'] = $this->modal_id; // Used to show correct status div
                header('Content-type: application/json');
                echo json_encode($response);
                exit;
            } else {
                return 'ok';
            }
        }

        protected function buildStatement()
        {
            $sql = '';
            switch ($this->category) {
                case 'news':
                    $sql = 'INSERT INTO news_comments
                                (`id`, `news_id`, `comment_subid`, `comment`, `author_id`, `posted`, `author`)';
                    break;
                case 'releases':
                    $sql = 'INSERT INTO release_comments
                                (`id`, `release_code`, `comment_subid`, `comment`, `author_id`, `posted`, `author`)';
                    break;
                case 'bio':
                    $sql = 'INSERT INTO performer_comments
                                (`id`, `performer_id`, `comment_subid`, `comment`, `author_id`, `posted`, `author`)';
                    break;
                default:
                    break;
            }
            $sql .= ' VALUES(
                0,
                :id,
                :subid,
                :comment,
                :author_id,
                :date_posted,
                :author_name
            )';

            return $sql;
        }

        protected function buildParameters()
        {
            $parameters = array(
                'id' => $this->comment_target_id,
                'subid' => $this->comment_sub_id,
                'comment' => $this->comment,
                'author_id' => $this->user_id,
                'date_posted' => $this->date_posted,
                'author_name' => $this->user_display_name,
            );
            if (isset($this->category_comment_sub_id)) {
                $parameters['category_comment_subid'] = $this->category_comment_sub_id;
            }

            return $parameters;
        }

    }
