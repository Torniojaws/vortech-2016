<?php

    /*
        GET /members                          All members
        GET /members?year=2016                All members since 2016
        GET /members?year=2010&month=3        All members since March 2010

        GET /members/:id                      A specific member (1 = oldest news)
        GET /members/:id/comments             All comments for member {id}
        GET /members/:id/comments/:id         A specific comment for member {id}
    */

    /**
     * The members API is handled here. Based on the URI parameters, a number of different
     * SQL query strings are returned.
     * @param $root_id This is the ID of a particular member
     * @param $sub This contains a sub-item such as "comments", for accessing a given sub-item of a given member
     */
    function member_handler($root_id=null, $sub=null, $sub_id=null, $detail=null, $detail_id=null, $uri_filters=null) {

        $sql = "SELECT * FROM performers";

        // Use filters by appending to the end of the query (be mindful of LIMIT!)
        if(isset($uri_filters)) {
            $sql .= append_filters($uri_filters);
        }

        // For example all comments for a specific show
        if(isset($root_id) && isset($sub)) {
            if($sub == "comments") {
                if(isset($sub_id)) {
                    $sql = "SELECT * FROM member_comments";
                    $sql .= " WHERE member_id=" . $root_id;
                    $sql .= " AND member_comment_subid=" . $sub_id;
                } else {
                    $sql = "SELECT * FROM member_comments";
                    $sql .= "WHERE member_id=" . $root_id;
                }
            }
        }

        // A specific news item
        if(isset($root_id)) {
            $sql = "SELECT * FROM performers WHERE id=" . $root_id;
        }

        return $sql;
    }

    /**
     * All processing for endpoint filters is done Here
     * @param $uri Contains the parameters for the URI, eg. /members?para=meter
     * @return $sql Has the partial SQL code for implementing the filter
     */
    function append_filters($uri) {
        parse_str($uri);
        $sql = "";

        if(isset($year)) {
            $sql .= " WHERE YEAR(started) = " . $year;
            if(isset($month)) {
                $sql .= " AND MONTH(started) = " . $month;
            }
        }

        return $sql;
    }

?>
