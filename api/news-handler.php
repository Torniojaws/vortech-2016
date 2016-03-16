<?php

    function news_handler($root_id=null, $sub=null, $sub_id=null) {

        $sql = "SELECT * FROM news";

        // For example all comments for a specific news
        if(isset($root_id) && isset($sub)) {
            if($sub == "comments") {
                // Can also be a specific comment
                if(isset($sub_id)) {
                    $sql = "SELECT * FROM news_comments WHERE news_id=" . $root_id . " AND id=" . $sub_id;
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
