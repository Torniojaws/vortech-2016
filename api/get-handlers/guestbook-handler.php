<?php

    /*
        GET /guestbook                           All guestbook

        GET /guestbook/:id                       A specific guestbook (1 = oldest guestbook)
        GET /guestbook/:id/comments              All comments for guestbook {id}
        GET /guestbook/:id/comments/:id          A specific comment for guestbook {id}

        GET /guestbook/:id/songs                 All songs for guestbook {id}
        GET /guestbook/:id/songs/:id             A specific song for guestbook {id}
        GET /guestbook/:id/songs/:id/comments    Comments for a specific song
    */

    function guestbook_handler($root_id=null,
                               $sub=null, $sub_id=null, $detail=null, $detail_id=null, $uri_filters=null) {

        // Unless otherwise specified, we'll return all guestbook postss
        $sql = "SELECT guestbook.*, users.id AS userid, users.photo_id, users.name AS username, ";
        $sql .= "guestbook_comments.author_id AS admin_id, ";
        $sql .= "guestbook_comments.comment AS admin_comment, guestbook_comments.posted AS admin_comment_date ";
        $sql .= "FROM guestbook";
        $sql .= " LEFT JOIN users ON users.id = guestbook.poster_id";
        $sql .= " LEFT JOIN guestbook_comments ON guestbook_comments.comment_subid = guestbook.id";
        $sql .= " ORDER BY guestbook.posted DESC";

        // Use filters by appending to the end of the query
        $filter_sql = "";
        if(isset($uri_filters)) {
            $sql .= append_filters($uri_filters);
        }

        // For example all comments for a specific guestbook
        if(isset($root_id) && isset($sub)) {

            if($sub == "comments") {
                if(isset($sub_id)) {
                    $sql = "SELECT * FROM guestbook_comments";
                    $sql .= " WHERE guestbook_id=" . $root_id;
                    $sql .= " AND comment_subid=" . $sub_id;
                    $sql .= " LIMIT 1";
                } else {
                    $sql = "SELECT * FROM guestbook_comments";
                    $sql .= " WHERE guestbook_id=" . $root_id;
                }
            }

            if($sub == "songs") {
                if(isset($sub_id)) {
                    $sql = "SELECT * FROM songs";
                    $sql .= " WHERE guestbook_id=" . $root_id;
                    $sql .= " AND song_id=" . $sub_id;
                    $sql .= " LIMIT 1";
                } else {
                    $sql = "SELECT * FROM songs";
                    $sql .= " WHERE guestbook_id=" . $root_id;
                }
            }

        } else if(isset($root_id)) {
            // A specific news item
            $sql = "SELECT * FROM guestbook WHERE id=" . $root_id;
        }

        return $sql;
    }

    function append_filters($uri) {
        $filter_sql = " WHERE";
        parse_str($uri);

        if(isset($year)) {
            $filter_year = $year;
            $filter_sql = " YEAR(guestbook_date) = " . $filter_year;
        }

        if(isset($yearrange)) {
            list($start, $end) = explode("-", $yearrange);
            $filter_yearstart = $start;
            $filter_yearend = $end;
            $filter_sql .= " YEAR(guestbook_date) BETWEEN " . $start . " AND " . $end;
        }
        return $filter_sql;
    }

?>
