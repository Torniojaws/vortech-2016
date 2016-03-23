<?php

    /*
        PUT /visitors       Update visitor count with $data
    */

    /**
     * @return $sql Visitor count update SQL
     */
    function visitor_handler($data) {

        if(isset($data['increment'])) {
            $sql = "UPDATE visitor_count SET count = count + " . $data['increment'];
        } else {
            $sql = "";
        }
        return $sql;

    }

?>
