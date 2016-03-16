<?php

    /*
        GET /news                           All news
        GET /news?year=2016                 All news from 2016
        GET /news?year-range=2010-2016      All news from between 2010 and 2016

        GET /news/:id                       A specific news (1 = oldest news)
        GET /news/:id/comments              All comments for news {id}
        GET /news/:id/comments/:id          A specific comment for release {id}

        GET /news/:id/songs                 All songs for release {id}
        GET /news/:id/songs/:id             A specific song for release {id}
        GET /news/:id/songs/:id/comments    Comments for a specific song

        $uri_filters contains any filters applied. Eg, news?year=2015
    */

    function news_handler($root_id=null, $sub=null, $sub_id=null, $detail=null, $detail_id=null, $uri_filters=null) {

        $sql = "SELECT * FROM news";

        // Use filters by appending to the end of the query (be mindful of LIMIT!)
        if(isset($uri_filters)) {
            parse_str($uri_filters);
            if(isset($year)) {
                $sql .= " WHERE YEAR(posted) = " . $year;
            }
        }

        // For example all comments for a specific news
        if(isset($root_id) && isset($sub)) {
            if($sub == "comments") {
                // Can also be a specific comment
                if(isset($sub_id)) {
                    $sql = "SELECT * FROM news_comments WHERE news_id=" . $root_id . " AND comment_subid=" . $sub_id;
                } else {
                    $sql = "SELECT * FROM news_comments WHERE news_id=" . $root_id;
                }
            }
        }

        // A specific news item
        if(isset($root_id)) {
            $sql = "SELECT * FROM news WHERE id=" . $root_id;
        }

        return $sql;
    }

?>
