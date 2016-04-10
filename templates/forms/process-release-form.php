<?php

    session_start();

    // Mandatory fields
    $artist = $_POST['artist'];
    $album = $_POST['album'];
    $release_date = $_POST['date']; # yyyy-mm-dd hh:mm:ss
    // Optional fields
    $songs = $_POST['songlist'];
    $release_code = null;
    if (isset($_POST['code'])) {
        $release_code = $_POST['code'];
    }
    $has_cd = null;
    if (isset($_POST['has-cd'])) {
        $has_cd = $_POST['has-cd']; # yes | no
    }
    $publish_date = null;
    if (isset($_POST['web-publish-date'])) {
        $publish_date = $_POST['web-publish-date']; # yyyy-mm-dd hh:mm:ss
    }

    // Songs are a list of strings starting with #
    if (isset($songs)) {
        $songlist = array_filter(explode('#', $songs), 'strlen');
    }

    if ($_SESSION['authorized'] == 1 && isset($artist) && isset($album) && isset($release_date)) {
        // Because this runs from a subdir /root/templates
        $root = str_replace('templates/forms', '', dirname(__FILE__));
        require_once $root.'/api/classes/Database.php';

        $db = new Database();
        $db->connect();

        $statement = 'INSERT INTO releases VALUES(
            0,
            :album,
            :release_code,
            :release_date,
            :artist,
            :has_cd,
            :publish_date
        )';
        $params = array(
            'artist' => $artist,
            'album' => $album,
            'release_date' => $release_date,
            'release_code' => $release_code,
            'has_cd' => $has_cd,
            'publish_date' => $publish_date,
        );
        $db->run($statement, $params);
        $db->close();

        // Add songs
        if (isset($songlist)) {
            $counter = 0;
            foreach ($songlist as $song) {
                ++$counter;

                $dbSong = new Database();
                $dbSong->connect();

                // Clean-up
                $song = trim($song);

                // eg. "Söng Title (Possibly Ünicodë) (01:23)"
                $title = trim(mb_substr($song, 0, -7));
                $duration = substr($song, -7);
                $parenthesis = array('(', ')');
                $duration = str_replace($parenthesis, '', $duration);
                $duration = '00:'.$duration; // 00: is for "time" format in SQL, eg. 00:01:23

                // Probably not that efficient, but this is done very rarely
                $statement = 'INSERT INTO songs VALUES(
                    0,
                    :release_code,
                    :song_number_on_release,
                    :title,
                    :duration
                )';
                $params = array(
                    'release_code' => $release_code,
                    'song_number_on_release' => $counter,
                    'title' => $title,
                    'duration' => $duration,
                );
                $dbSong->run($statement, $params);
                $dbSong->close();
            }
        }

        if ($db->querySuccessful()) {
            $response['status'] = 'success';
            $response['message'] = 'Album added to DB';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to add album to DB!';
        }
    }

    header('Content-type: application/json');
    echo json_encode($response);
