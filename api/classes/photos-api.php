<?php

    class PhotosAPI
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

        private function getQuery($args, $filters=null)
        {
            switch ($args)
            {

                # /photos
                case isset($args[2]) == false and isset($filters) == false:
                    $query['statement'] = 'SELECT photos.*, photo_albums.id AS photo_album_id, photo_albums.category_id,
                                                  photo_albums.show_in_gallery, photo_categories.name_id,
                                                  photo_categories.name
                                           FROM photos
                                           JOIN photo_albums ON photo_albums.id = photos.album_id
                                           JOIN photo_categories ON photo_categories.id = photo_albums.category_id
                                           ORDER BY photos.id ASC';
                    $query['params'] = array();
                    break;

                # /photos?year=2015
                case isset($args[2]) == false and isset($filters):
                    // Expected parse_str variables are "year" or "yearrange"
                    parse_str($filters);
                    $query['statement'] = 'SELECT photos.*, photo_albums.id AS photo_album_id, photo_albums.category_id,
                                                  photo_albums.show_in_gallery, photo_categories.name_id,
                                                  photo_categories.name
                                           FROM photos
                                           JOIN photo_albums ON photo_albums.id = photos.album_id
                                           JOIN photo_categories ON photo_categories.id = photo_albums.category_id';
                    if (isset($year)) {
                        $query['statement'] .= ' WHERE YEAR(date_taken) = :year';
                        $query['params'] = array("year" => (int)$year);
                    } else if (isset($yearrange)) {
                        list($yearstart, $yearend) = explode('-', $yearrange);
                        $query['statement'] .= ' WHERE YEAR(date_taken) BETWEEN :yearstart AND :yearend';
                        $query['params'] = array("yearstart" => (int)$yearstart, "yearend" => (int)$yearend);
                    }
                    $query['statement'] .= ' ORDER BY photos.id ASC';
                    break;

                # /photos/:id
                case isset($args[2]) and is_numeric($args[2]) and isset($args[3]) == false:
                    $query['statement'] = 'SELECT photos.*, photo_albums.id AS photo_album_id, photo_albums.category_id,
                                                  photo_albums.show_in_gallery, photo_categories.name_id,
                                                  photo_categories.name
                                           FROM photos
                                           JOIN photo_albums ON photo_albums.id = photos.album_id
                                           JOIN photo_categories ON photo_categories.id = photo_albums.category_id
                                           WHERE photos.id = :id
                                           LIMIT 1';
                    $query['params'] = array("id" => (int)$args[2]);
                    break;

                # /photos/:category
                case isset($args[2]) and is_numeric($args[2]) == false and isset($args[3]) == false:
                    $query['statement'] = 'SELECT photos.*, photo_albums.id AS photo_album_id, photo_albums.category_id,
                                                  photo_albums.show_in_gallery, photo_categories.name_id,
                                                  photo_categories.name
                                           FROM photos
                                           JOIN photo_albums ON photo_albums.id = photos.album_id
                                           JOIN photo_categories ON photo_categories.id = photo_albums.category_id
                                           WHERE photo_categories.name_id = :category';
                    $query['params'] = array("category" => $args[2]);
                    break;

                # /photos/:id/comments
                case isset($args[2]) and is_numeric($args[2]) and isset($args[3])
                     and $args[3] == 'comments' and isset($args[4]) == false:
                    $query['statement'] = 'SELECT photo_comments.*, photos.*, photo_albums.*, photo_categories.*
                                           FROM photo_comments
                                           JOIN photos ON photos.id = photo_comments.photo_id
                                           JOIN photo_albums ON photo_albums.id = photos.album_id
                                           JOIN photo_categories ON photo_categories.id = photo_albums.category_id
                                           WHERE photos.id = :id';
                    $query['params'] = array("id" => (int)$args[2]);
                    break;

                # /photos/:category/comments
                case isset($args[2]) and is_numeric($args[2]) == false and isset($args[3])
                     and $args[3] == 'comments' and isset($args[4]) == false:
                    $query['statement'] = 'SELECT photo_comments.*, photos.id AS photos_id, photos.album_id,
                                                  photo_albums.id AS photo_album_id, photo_albums.category_id,
                                                  photo_albums.show_in_gallery, photo_categories.name_id,
                                                  photo_categories.name
                                           FROM photo_comments
                                           LEFT JOIN photos ON photos.id = photo_comments.photo_id
                                           LEFT JOIN photo_albums ON photo_albums.id = photos.album_id
                                           LEFT JOIN photo_categories ON photo_categories.id = photo_albums.category_id
                                           WHERE photo_categories.name_id = :category';
                    $query['params'] = array("category" => $args[2]);
                    break;

                # /photos/:id/comments/:id
                case isset($args[2]) and is_numeric($args[2]) and isset($args[3])
                     and $args[3] == 'comments' and isset($args[4]) and is_numeric($args[4]):
                    $query['statement'] = 'SELECT photo_comments.*, photos.*, photo_albums.*, photo_categories.*
                                           FROM photo_comments
                                           JOIN photos ON photos.id = photo_comments.photo_id
                                           JOIN photo_albums ON photo_albums.id = photos.album_id
                                           JOIN photo_categories ON photo_categories.id = photo_albums.category_id
                                           WHERE photos.id = :id AND photo_comments.photo_comment_id = :comment_id';
                    $query['params'] = array("id" => (int)$args[2], "comment_id" => (int)$args[4]);
                    break;

                # /photos/:category/comments/:id
                case isset($args[2]) and is_numeric($args[2]) == false and isset($args[3])
                     and $args[3] == 'comments' and isset($args[4]) and is_numeric($args[4]):
                    $query['statement'] = 'SELECT photo_comments.*, photos.id AS photos_id, photos.album_id,
                                                  photo_albums.id AS photo_album_id, photo_albums.category_id,
                                                  photo_albums.show_in_gallery, photo_categories.name_id,
                                                  photo_categories.name
                                           FROM photo_comments
                                           JOIN photos ON photos.id = photo_comments.photo_id
                                           JOIN photo_albums ON photo_albums.id = photos.album_id
                                           JOIN photo_categories ON photo_categories.id = photo_albums.category_id
                                           WHERE photo_categories.name_id = :category
                                                 AND photo_comments.category_comment_subid = :id';
                    $query['params'] = array("category" => $args[2], "id" => (int)$args[4]);
                    break;

                # Show all - same as /photos
                default:
                    $query['statement'] = 'SELECT * FROM photos ORDER BY date_taken DESC';
                    $query['params'] = array();
            } // switch ($args)
            return $query;
        } // getQuery()

    }
