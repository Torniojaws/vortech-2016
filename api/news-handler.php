<?php

    /*
        GET /news                           All news
        GET /news?year=2016                 All news from 2016
        GET /news?year=2010&month=3         All news from March 2010

        GET /news/:id                       A specific news (1 = oldest news)
        GET /news/:id/comments              All comments for news {id}
        GET /news/:id/comments/:id          A specific comment for release {id}

        GET /news/:id/songs                 All songs for release {id}
        GET /news/:id/songs/:id             A specific song for release {id}
        GET /news/:id/songs/:id/comments    Comments for a specific song
    */

    /**
     * The News API is handled here. Based on the URI parameters, a number of different
     * SQL query strings are returned.
     * @param $root_id This is the ID of a particular news item
     * @param $sub This contains a sub-item such as "comments", for accessing a given sub-item of a given news item
     */
    function news_handler($root_id=null, $sub=null, $sub_id=null, $detail=null, $detail_id=null, $uri_filters=null) {

        $sql = "SELECT * FROM news";

        // Use filters by appending to the end of the query (be mindful of LIMIT!)
        if(isset($uri_filters)) {
            $sql .= append_filters($uri_filters);
        }

        // For example all comments for a specific news
        if(isset($root_id) && isset($sub)) {
            if($sub == "comments") {
                if(isset($sub_id)) {
                    $sql = "SELECT * FROM news_comments";
                    $sql .= " WHERE news_id=" . $root_id;
                    $sql .= " AND comment_subid=" . $sub_id;
                } else {
                    $sql = "SELECT * FROM news_comments";
                    $sql .= "WHERE news_id=" . $root_id;
                }
            }
        }

        // A specific news item
        if(isset($root_id)) {
            $sql = "SELECT * FROM news WHERE id=" . $root_id;
        }

        return $sql;
    }

    /**
     * All processing for endpoint filters is done Here
     * @param $uri Contains the parameters for the URI, eg. /news?para=meter
     * @return $sql Has the partial SQL code for implementing the filter
     */
    function append_filters($uri) {
        parse_str($uri);
        $sql = "";

        if(isset($year)) {
            $sql .= " WHERE YEAR(posted) = " . $year;
            if(isset($month)) {
                $sql .= " AND MONTH(posted) = " . $month;
            }
        }

        return $sql;
    }

?>
