<?php

    /*
        GET /videos                           All videos

        GET /videos/:id                       A specific video (1 = oldest video)
        GET /videos/:id/comments              All comments for video {id}
        GET /videos/:id/comments/:id          A specific comment for video {id}

        GET /videos/:id/songs                 All songs for video {id}
        GET /videos/:id/songs/:id             A specific song for video {id}
        GET /videos/:id/songs/:id/comments    Comments for a specific song
    */

    function video_handler(
        $root_id=null,
        $sub=null,
        $sub_id=null,
        $detail=null,
        $detail_id=null,
        $uri_filters=null
    ) {
        // Unless otherwise specified, we'll return all videos
        $sql = 'SELECT videos.*, video_categories.name, video_categories.description FROM videos';
        $sql .= ' JOIN video_categories ON video_categories.id = videos.category_id';
        $sql .= ' ORDER BY id';

        // Use filters by appending to the end of the query
        $filter_sql = '';
        if (isset($uri_filters)) {
            $sql .= append_filters($uri_filters);
        }

        // For example all comments for a specific video
        if (isset($root_id) && isset($sub)) {
            if($sub == 'comments') {
                if(isset($sub_id)) {
                    $sql = 'SELECT * FROM video_comments';
                    $sql .= ' WHERE video_id=' . $root_id;
                    $sql .= ' AND comment_subid=' . $sub_id;
                    $sql .= ' LIMIT 1';
                } else {
                    $sql = 'SELECT * FROM video_comments';
                    $sql .= ' WHERE video_id=' . $root_id;
                }
            }

            if($sub == 'songs') {
                if(isset($sub_id)) {
                    $sql = 'SELECT * FROM songs';
                    $sql .= ' WHERE video_id=' . $root_id;
                    $sql .= ' AND song_id=' . $sub_id;
                    $sql .= ' LIMIT 1';
                } else {
                    $sql = 'SELECT * FROM songs';
                    $sql .= ' WHERE video_id=' . $root_id;
                }
            }

        } else if(isset($root_id)) {
            // A specific news item
            $sql = 'SELECT * FROM videos WHERE id=' . $root_id;
        }

        return $sql;
    }

    function append_filters($uri) {
        $filter_sql = ' WHERE';
        parse_str($uri);

        if(isset($year)) {
            $filter_year = $year;
            $filter_sql = ' YEAR(video_date) = ' . $filter_year;
        }

        if(isset($yearrange)) {
            list($start, $end) = explode('-', $yearrange);
            $filter_yearstart = $start;
            $filter_yearend = $end;
            $filter_sql .= ' YEAR(video_date) BETWEEN ' . $start . ' AND ' . $end;
        }
        return $filter_sql;
    }

?>
