<?php

    /*
        GET /shopitems                          All shopitems
        GET /shopitems?year=2016                All shopitems from 2016
        GET /shopitems?year=2010&month=3        All shopitems from March 2010

        GET /shopitems/:id                      A specific shopitem (1 = oldest news)
        GET /shopitems/:id/comments             All comments for shopitem {id}
        GET /shopitems/:id/comments/:id         A specific comment for shopitem {id}
    */

    /**
     * The shopitems API is handled here. Based on the URI parameters, a number of different
     * SQL query strings are returned.
     * @param $root_id This is the ID of a particular shopitem
     * @param $sub This contains a sub-item such as "comments", for accessing a given sub-item of a given shopitem item
     */
    function shop_handler($root_id=null, $sub=null, $sub_id=null, $detail=null, $detail_id=null, $uri_filters=null) {

        $sql = "SELECT shop_items.*, shop_categories.name_id FROM shop_items";
        $sql .= " JOIN shop_categories ON shop_categories.id = shop_items.category_id";
        $sql .= " ORDER BY id";

        // Use filters by appending to the end of the query (be mindful of LIMIT!)
        if(isset($uri_filters)) {
            $sql .= append_filters($uri_filters);
        }

        // For example all comments for a specific shopitem
        if(isset($root_id) && isset($sub)) {
            if($sub == "comments") {
                if(isset($sub_id)) {
                    $sql = "SELECT * FROM shopitem_comments";
                    $sql .= " WHERE shopitem_id=" . $root_id;
                    $sql .= " AND comment_subid=" . $sub_id;
                } else {
                    $sql = "SELECT * FROM shopitem_comments";
                    $sql .= "WHERE shopitem_id=" . $root_id;
                }
            }
        }

        // A specific shop item
        if(isset($root_id)) {
            $sql = "SELECT shop_items.*, shop_categories.name_id FROM shop_items";
            $sql .= " JOIN shop_categories ON shop_categories.id = shop_items.category_id";
            $sql .= " ORDER BY id";
        }

        return $sql;
    }

    /**
     * All processing for endpoint filters is done Here
     * @param $uri Contains the parameters for the URI, eg. /shopitems?para=meter
     * @return $sql Has the partial SQL code for implementing the filter
     */
    function append_filters($uri) {
        parse_str($uri);
        $sql = "";

        if(isset($year)) {
            $sql .= " WHERE YEAR(shopitem_date) = " . $year;
            if(isset($month)) {
                $sql .= " AND MONTH(shopitem_date) = " . $month;
            }
        }

        return $sql;
    }

?>
