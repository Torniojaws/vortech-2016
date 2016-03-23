<?php

    /*
        GET /visitors   Visitor count
    */

    /**
     * @return $sql Visitor count SQL
     */
    function visitor_handler() {

        $sql = "SELECT count FROM visitor_count LIMIT 1";
        return $sql;

    }

?>
