<?php

    class ArticlesAPI
    {
        public $result;

        public function __construct($request, $filters = null)
        {
            $this->result = $this->getQuery($request, $filters);
        }

        public function getResult()
        {
            return $this->result;
        }

        private function getQuery($args, $filters = null)
        {
            switch ($args) {
                # /articles
                case isset($args[2]) == false and isset($filters) == false:
                    $query['statement'] = 'SELECT * FROM articles';
                    $query['params'] = array();
                    break;

                # /articles?category=name
                # /articles?category=name&subid=123
                case isset($args[2]) == false and isset($filters):
                    parse_str($filters);
                    // All for specific category
                    if (isset($category)) {
                        $query['statement'] = 'SELECT * FROM articles WHERE category = :category';
                        $query['params'] = array('category' => $category);
                    }
                    // All for specific category and specific ID
                    if (isset($category) and isset($subid)) {
                        $query['statement'] = 'SELECT *
                                               FROM articles
                                               WHERE category = :category
                                                    AND subid = :subid
                                               LIMIT 1';
                        $query['params'] = array(
                            'category' => $category,
                            'subid' => $subid,
                        );
                    }
                    break;

                # /articles/:id
                case isset($args[2]) and isset($args[3]) == false:
                    $query['statement'] = 'SELECT * FROM articles WHERE id = :id LIMIT 1';
                    $query['params'] = array('id' => (int) $args[2]);
                    break;

                # /articles/:id/comments
                case isset($args[2]) and isset($args[3]) and $args[3] == 'comments' and isset($args[4]) == false:
                    $query['statement'] = 'SELECT * FROM article_comments WHERE article_id = :id';
                    $query['params'] = array('id' => (int) $args[2]);
                    break;

                # /articles/:id/comments/:id
                case isset($args[2]) and isset($args[3]) and $args[3] == 'comments' and isset($args[4]):
                    $query['statement'] = 'SELECT *
                                           FROM article_comments
                                           WHERE comment_subid = :id AND article_id = :article_id LIMIT 1';
                    $query['params'] = array('id' => (int) $args[4], 'article_id' => (int) $args[2]);
                    break;

                # Show all - same as /articles
                default:
                    $query['statement'] = 'SELECT * FROM articles ORDER BY id DESC';
                    $query['params'] = array();
            }

            return $query;
        }
    }
