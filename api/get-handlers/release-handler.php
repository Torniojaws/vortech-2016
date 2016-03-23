<?php

    /*
        GET /releases                           All releases

        GET /releases/:id                       A specific release (1 = oldest release)
        GET /releases/:id/comments              All comments for release {id}
        GET /releases/:id/comments/:id          A specific comment for release {id}

        GET /releases/:id/songs                 All songs for release {id}
        GET /releases/:id/songs/:id             A specific song for release {id}
        GET /releases/:id/songs/:id/comments    Comments for a specific song
    */

    function release_handler($root_id=null, $sub=null, $sub_id=null, $detail=null, $detail_id=null, $uri_filters=null) {

        // Unless otherwise specified, we'll return all releases
        $sql = "SELECT * FROM releases";

        // Use filters by appending to the end of the query
        $filter_sql = "";
        if(isset($uri_filters)) {
            $sql .= append_filters($uri_filters);
        }

        // For example all comments for a specific release
        if(isset($root_id) && isset($sub)) {

            if($sub == "comments") {
                if(isset($sub_id)) {
                    $sql = "SELECT * FROM release_comments";
                    $sql .= " WHERE release_id=" . $root_id;
                    $sql .= " AND comment_subid=" . $sub_id;
                    $sql .= " LIMIT 1";
                } else {
                    $sql = "SELECT * FROM release_comments";
                    $sql .= " WHERE release_id=" . $root_id;
                }
            }

            if($sub == "songs") {
                if(isset($sub_id)) {
                    $sql = "SELECT * FROM songs";
                    $sql .= " WHERE release_id=" . $root_id;
                    $sql .= " AND song_id=" . $sub_id;
                    $sql .= " LIMIT 1";
                } else {
                    $sql = "SELECT * FROM songs";
                    $sql .= " WHERE release_id=" . $root_id;
                }
            }

        } else if(isset($root_id)) {
            // A specific news item
            $sql = "SELECT * FROM releases WHERE id=" . $root_id;
        }

        return $sql;
    }

    function append_filters($uri) {
        $filter_sql = " WHERE";
        parse_str($uri);

        if(isset($year)) {
            $filter_year = $year;
            $filter_sql = " YEAR(release_date) = " . $filter_year;
        }

        if(isset($yearrange)) {
            list($start, $end) = explode("-", $yearrange);
            $filter_yearstart = $start;
            $filter_yearend = $end;
            $filter_sql .= " YEAR(release_date) BETWEEN " . $start . " AND " . $end;
        }
        return $filter_sql;
    }

?>
