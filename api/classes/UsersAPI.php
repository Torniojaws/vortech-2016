<?php

    session_start();

    class UsersAPI
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
                # /users
                case isset($args[2]) == false and isset($filters) == false:
                    $query['statement'] = 'SELECT id, name FROM users';
                    $query['params'] = array();
                    break;

                # /users/:id
                case isset($args[2]) and is_numeric($args[2]) and isset($args[3]) == false:
                    $query['statement'] = 'SELECT id,
                                                  name
                                           FROM users
                                           WHERE id = :id LIMIT 1';
                    $query['params'] = array('id' => (int) $args[2]);
                    break;

                # /users/:name
                case isset($args[2]) and is_numeric($args[2]) == false and isset($args[3]) == false:
                    $query['statement'] = 'SELECT users.id,
                                                  users.name,
                                                  users.username,
                                                  users.caption,
                                                  photos.date_taken,
                                                  photos.full,
                                                  photos.thumbnail
                                           FROM users
                                           LEFT JOIN photos
                                                ON photos.user_id = users.id
                                                AND photos.album_id = 7
                                           WHERE username = :username
                                           LIMIT 1';
                    $query['params'] = array('username' => $args[2]);
                    break;

                # /users/:id/photo
                case isset($args[2]) and is_numeric($args[2]) and isset($args[3])
                     and $args[3] == 'photo':
                    $query['statement'] = 'SELECT * FROM article_comments WHERE author_id = :id
                                           FROM users
                                           WHERE id = :id LIMIT 1';
                    $query['params'] = array('id' => (int) $args[2]);
                    break;

                # /users/:id/activities
                case isset($args[2]) and is_numeric($args[2]) and isset($args[3])
                     and $args[3] == 'activities':
                    // The unioned items will appear with the same column name as the first item, regardless of original name
                    $query['statement'] = '(SELECT id, "article_comments" AS target, comment, author_id, date_commented
                                            FROM article_comments
                                            WHERE author_id = :id1
                                            LIMIT 5)
                                           UNION
                                           (SELECT id, "guestbook" AS target, post, poster_id, posted
                                            FROM guestbook
                                            WHERE poster_id = :id2
                                            LIMIT 5)
                                           UNION
                                           (SELECT id, "news_comments" AS target, comment, author_id, posted
                                            FROM news_comments
                                            WHERE author_id = :id3
                                            LIMIT 5)
                                           UNION
                                           (SELECT id, "performer_comments" AS target, comment, author_id, posted
                                            FROM performer_comments
                                            WHERE author_id = :id4
                                            LIMIT 5)
                                           UNION
                                           (SELECT id, "photo_comments" AS target, comment, author_id, date_commented
                                            FROM photo_comments
                                            WHERE author_id = :id5
                                            LIMIT 5)
                                           UNION
                                           (SELECT id, "release_comments" AS target, comment, author_id, posted
                                            FROM release_comments
                                            WHERE author_id = :id6
                                            LIMIT 5)
                                           UNION
                                           (SELECT id, "shopitem_comments" AS target, comment, author_id, date_commented
                                            FROM shopitem_comments
                                            WHERE author_id = :id7
                                            LIMIT 5)
                                           UNION
                                           (SELECT id, "show_comments" AS target, comment, author_id, posted
                                            FROM show_comments
                                            WHERE author_id = :id8
                                            LIMIT 5)
                                           UNION
                                           (SELECT id, "song_comments" AS target, comment, author_id, posted
                                            FROM song_comments
                                            WHERE author_id = :id9
                                            LIMIT 5)
                                           UNION
                                           (SELECT id, "video_comments" AS target, comment, author_id, date_commented
                                            FROM video_comments
                                            WHERE author_id = :id10
                                            LIMIT 5)
                                           ORDER BY date_commented DESC
                                           LIMIT 5
                                           ';
                    // PDO does not allow reuse of the same parameter name...
                    $query['params'] = array(
                        'id1' => (int) $args[2],
                        'id2' => (int) $args[2],
                        'id3' => (int) $args[2],
                        'id4' => (int) $args[2],
                        'id5' => (int) $args[2],
                        'id6' => (int) $args[2],
                        'id7' => (int) $args[2],
                        'id8' => (int) $args[2],
                        'id9' => (int) $args[2],
                        'id10' => (int) $args[2],
                    );
                    break;

                # Show all - same as /users
                default:
                    $query['statement'] = 'SELECT id, name, photo_id FROM users';
                    $query['params'] = array();
            }

            return $query;
        } // getQuery()
    }
