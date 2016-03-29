<?php

    /*
        GET /photos                         All photos
        GET /photos?year=2016               All photos from 2016
        GET /photos?year=2010&month=3       All photos from March 2010

        GET /photos/live                    All live photos
        GET /photos/promo                   All promo
        GET /photos/studio                  All studio
        GET /photos/misc                    All misc

        GET /photos/:id                     A specific show (1 = oldest news)
        GET /photos/:id/comments            All comments for show {id}
        GET /photos/:id/comments/:id        A specific comment for show {id}
    */

    /**
     * The photos API is handled here. Based on the URI parameters, a number of different
     * SQL query strings are returned.
     * @param $root_id The ID of a particular photo (if number), but can also be album group name (live, promo...)
     * @param $sub This contains a sub-item such as "comments", for accessing a given sub-item of a given show item
     */
    function photo_handler($root_id=null, $sub=null, $sub_id=null, $detail=null, $detail_id=null, $uri_filters=null) {

        // By default, all photos along with the category details for file path (static/img/path/file.jpg)
        $sql = "SELECT photos.*, photo_albums.id, photo_albums.category_id, photo_albums.show_in_gallery, ";
        $sql .= "photo_categories.name_id, photo_categories.name";
        $sql .= " FROM photos";
        $sql .= " JOIN photo_albums ON photo_albums.id = photos.album_id";
        $sql .= " JOIN photo_categories ON photo_categories.id = photo_albums.category_id";

        // Use filters by appending to the end of the query (be mindful of LIMIT!)
        if(isset($uri_filters)) {
            $sql .= append_filters($uri_filters);
        }

        // eg. GET /photos/123
        // eg. GET /photos/123/comments
        // eg. GET /photos/123/comments/123
        if(is_numeric($root_id)) {
            if(isset($sub)) {
                if($sub == 'comments') {
                    $sql = "SELECT * FROM photo_comments";
                    $sql .= " WHERE photo_id=" . $root_id;
                    if(isset($sub_id) && is_numeric($sub_id)) {
                        $sql .= " AND photo_comment_id=" . $sub_id . " LIMIT 1";
                    }
                }
            } else {
                $sql = "SELECT photos.*, photo_albums.id, photo_albums.category_id, photo_albums.show_in_gallery, ";
                $sql .= "photo_categories.id, photo_categories.name_id";
                $sql .= " FROM photos";
                $sql .= " JOIN photo_albums ON photo_albums.id = photos.album_id";
                $sql .= " JOIN photo_categories ON photo_categories.id = photo_albums.category_id";
                $sql .= sprintf(" WHERE photos.id='%s'", $root_id);
                # $sql .= " WHERE id=" . $root_id;
            }
        }

        // eg. GET /photos/promo                    All promo photos
        // eg. GET /photos/promo/comments           All comments for all promo pics
        // eg. GET /photos/promo/comments/123       Doesn't really make sense though
        // eg. GET /photos/promo/123                Specific promo photo
        // eg. GET /photos/promo/123/comments       Comments for specific promo photo
        // eg. GET /photos/promo/123/comments/123   Specific comment for specific promo pic
        if(isset($root_id) && is_numeric($root_id) == false) {
            if(isset($sub)) {
                if(is_numeric($sub)) {

                } else {
                    if($sub == 'comments') {
                        $sql = "SELECT photo_comments.*, photos.*, photo_albums.*, photo_categories.*";
                        $sql .= " FROM photo_comments";
                        $sql .= " JOIN photos";
                        $sql .= " ON photos.id = photo_comments.photo_id";
                        $sql .= " JOIN photo_albums";
                        $sql .= " ON photo_albums.id = photos.album_id";
                        $sql .= " JOIN photo_categories";
                        $sql .= " ON photo_categories.id = photo_albums.category_id";
                        $sql .= sprintf(" WHERE photo_categories.name_id='%s'", $root_id);
                        if(isset($sub_id) && is_numeric($sub_id)) {
                            $sql .= " AND photo_comments.id=" . $sub_id;
                        }
                    }
                }
            } else {
                $sql = "SELECT photos.*, photo_albums.*, photo_categories.*";
                $sql .= " FROM photos";
                $sql .= " JOIN photo_albums";
                $sql .= " ON photo_albums.id = photos.album_id";
                $sql .= " JOIN photo_categories";
                $sql .= " ON photo_categories.id = photo_albums.category_id";
                $sql .= sprintf(" WHERE photo_categories.name_id='%s'", $root_id);
            }
        }
        return $sql;
    }

    /**
     * All processing for endpoint filters is done Here
     * @param $uri Contains the parameters for the URI, eg. /photos?para=meter
     * @return $sql Has the partial SQL code for implementing the filter
     */
    function append_filters($uri) {
        parse_str($uri);
        $sql = "";

        if(isset($year)) {
            $sql .= " WHERE YEAR(date_taken) = " . $year;
            if(isset($month)) {
                $sql .= " AND MONTH(date_taken) = " . $month;
            }
        }

        return $sql;
    }

?>
