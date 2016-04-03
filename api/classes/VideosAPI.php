<?php

    class VideosAPI
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
                # /videos
                case isset($args[2]) == false and isset($filters) == false:
                    $query['statement'] = 'SELECT videos.*,
                                                  video_categories.name,
                                                  video_categories.description
                                           FROM videos
                                           JOIN video_categories
                                                ON video_categories.id = videos.category_id
                                           ORDER BY id';
                    $query['params'] = array();
                    break;

                # /videos?type=studio
                case isset($args[2]) == false and isset($filters):
                    // Expected parse_str variables are "studio", "live", "mv" and "album"
                    // mv = music video
                    parse_str($filters);
                    switch (strtolower($type)) {
                        case 'live':
                            $type_id = 1;
                            break;
                        case 'studio':
                            $type_id = 2;
                            break;
                        case 'mv':
                            $type_id = 3;
                            break;
                        case 'album':
                            $type_id = 4;
                            break;
                        default:
                            $type_id = 1;
                            break;
                    }
                    $query['statement'] = 'SELECT videos.*,
                                                  video_categories.name,
                                                  video_categories.description
                                           FROM videos
                                           JOIN video_categories
                                                ON video_categories.id = videos.category_id
                                           WHERE video_categories.id = :type_id
                                           ORDER BY id';
                    $query['params'] = array('type_id' => (int) $type_id);
                    break;

                # /videos/:id
                case isset($args[2]) and is_numeric($args[2]) and isset($args[3]) == false:
                    $query['statement'] = 'SELECT videos.*,
                                                  video_categories.name,
                                                  video_categories.description
                                           FROM videos
                                           JOIN video_categories
                                                ON video_categories.id = videos.category_id
                                           WHERE videos.id = :id';
                    $query['params'] = array('id' => (int) $args[2]);
                    break;

                # /videos/:id/comments
                case isset($args[2]) and is_numeric($args[2]) and isset($args[3])
                     and $args[3] == 'comments' and isset($args[4]) == false:
                    $query['statement'] = 'SELECT video_comments.*,
                                                  videos.*,
                                                  video_categories.name,
                                                  video_categories.description
                                           FROM video_comments
                                           JOIN videos
                                                ON videos.id = :id
                                           JOIN video_categories
                                                ON video_categories.id = videos.category_id
                                           WHERE video_comments.video_id = :id';
                    $query['params'] = array('id' => (int) $args[2]);
                    break;

                # /videos/:id/comments/:id
                case isset($args[2]) and is_numeric($args[2]) and isset($args[3])
                     and $args[3] == 'comments' and isset($args[4]) and is_numeric($args[4]):
                    $query['statement'] = 'SELECT video_comments.*,
                                                  videos.*,
                                                  video_categories.name,
                                                  video_categories.description
                                           FROM video_comments
                                           JOIN videos
                                                ON videos.id = :id
                                           JOIN video_categories
                                                ON video_categories.id = videos.category_id
                                           WHERE video_comments.video_id = :id
                                                AND video_comments.video_comment_id = :comment_id';
                    $query['params'] = array(
                        'id' => (int) $args[2],
                        'comment_id' => (int) $args[4]
                    );
                    break;

                # Show all - same as /shows
                default:
                    $query['statement'] = 'SELECT * FROM videos ORDER BY id DESC';
                    $query['params'] = array();
            }

            return $query;
        } // getQuery()
    }
