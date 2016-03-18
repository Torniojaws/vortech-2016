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
     * @param $root_id This is the ID of a particular photo (if number), but can also be album group name (live, promo...)
     * @param $sub This contains a sub-item such as "comments", for accessing a given sub-item of a given show item
     */
    function photo_handler($root_id=null, $sub=null, $sub_id=null, $detail=null, $detail_id=null, $uri_filters=null) {

        $sql = "SELECT * FROM photos";

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
                $sql = "SELECT * FROM photos";
                $sql .= " WHERE id=" . $root_id;
            }
        }

        // eg. GET /photos/promo
        // eg. GET /photos/promo/comments
        // eg. GET /photos/promo/comments/123
        // eg. GET /photos/promo/123
        // eg. GET /photos/promo/123/comments
        // eg. GET /photos/promo/123/comments/123
        if(isset($root_id) && is_numeric($root_id) == false) {
            // Specific image from that group, eg. /photos/live/123
            if(isset($sub)) {
                $sql = "SELECT * FROM photos";
                $sql .= sprintf(" WHERE group_name='%s'", ucfirst($root_id));
                $sql .= " AND album_photo_id=" . $sub;
            } else {
                $sql = "SELECT * FROM photos";
                $sql .= sprintf(" WHERE group_name='%s'", ucfirst($root_id));
            }
        }
        echo $sql;
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
