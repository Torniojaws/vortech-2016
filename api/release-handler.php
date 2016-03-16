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

    function release_handler($root_id=null, $sub=null, $sub_id=null) {

        // Unless otherwise specified, we'll return all releases
        $sql = "SELECT * FROM releases";

        // For example all comments for a specific release
        if(isset($root_id) && isset($sub)) {
            if($sub == "comments") {
                if(isset($sub_id)) {
                    $sql = "SELECT * FROM release_comments WHERE album_id=" . $root_id . " AND id=" . $sub_id . " LIMIT=1";
                } else {
                    $sql = "SELECT * FROM release_comments WHERE album_id=" . $root_id;
                }
            }
            if($sub == "songs") {
                if(isset($sub_id)) {
                    $sql = "SELECT * FROM songs WHERE album_id=" . $root_id . " AND id=" . $sub_id . " LIMIT=1";
                } else {
                    $sql = "SELECT * FROM songs WHERE album_id=" . $root_id;
                }
            }
        } else if(isset($root_id)) {
            // A specific news item
            $sql = "SELECT * FROM releases WHERE id=" . $root_id;
        }

        echo $sql;
        return $sql;

    }

?>
