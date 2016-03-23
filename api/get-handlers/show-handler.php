<?php

    /*
        GET /shows                          All shows
        GET /shows?year=2016                All shows from 2016
        GET /shows?year=2010&month=3        All shows from March 2010

        GET /shows/:id                      A specific show (1 = oldest news)
        GET /shows/:id/comments             All comments for show {id}
        GET /shows/:id/comments/:id         A specific comment for show {id}
    */

    /**
     * The Shows API is handled here. Based on the URI parameters, a number of different
     * SQL query strings are returned.
     * @param $root_id This is the ID of a particular show
     * @param $sub This contains a sub-item such as "comments", for accessing a given sub-item of a given show item
     */
    function show_handler($root_id=null, $sub=null, $sub_id=null, $detail=null, $detail_id=null, $uri_filters=null) {

        $sql = "SELECT * FROM shows";

        // Use filters by appending to the end of the query (be mindful of LIMIT!)
        if(isset($uri_filters)) {
            $sql .= append_filters($uri_filters);
        }

        // For example all comments for a specific show
        if(isset($root_id) && isset($sub)) {
            if($sub == "comments") {
                if(isset($sub_id)) {
                    $sql = "SELECT * FROM show_comments";
                    $sql .= " WHERE show_id=" . $root_id;
                    $sql .= " AND comment_subid=" . $sub_id;
                } else {
                    $sql = "SELECT * FROM show_comments";
                    $sql .= "WHERE show_id=" . $root_id;
                }
            }
        }

        // A specific news item
        if(isset($root_id)) {
            $sql = "SELECT * FROM shows WHERE id=" . $root_id;
        }

        return $sql;
    }

    /**
     * All processing for endpoint filters is done Here
     * @param $uri Contains the parameters for the URI, eg. /shows?para=meter
     * @return $sql Has the partial SQL code for implementing the filter
     */
    function append_filters($uri) {
        parse_str($uri);
        $sql = "";

        if(isset($year)) {
            $sql .= " WHERE YEAR(show_date) = " . $year;
            if(isset($month)) {
                $sql .= " AND MONTH(show_date) = " . $month;
            }
        }

        return $sql;
    }

?>
