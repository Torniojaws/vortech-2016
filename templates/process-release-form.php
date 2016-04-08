<?php

    session_start();

    // Mandatory fields
    $artist         = $_POST['artist'];
    $album          = $_POST['album'];
    $release_date   = $_POST['date']; # yyyy-mm-dd hh:mm:ss
    // Optional fields
    $release_code = null;
    if(isset($_POST['code'])) {
        $release_code = $_POST['code'];
    }
    $has_cd = null;
    if(isset($_POST['has-cd'])) {
        $has_cd = $_POST['has-cd']; # yes | no
    }
    $publish_date = null;
    if(isset($_POST['web-publish-date'])) {
        $publish_date   = $_POST['web-publish-date']; # yyyy-mm-dd hh:mm:ss
    }

    if ($_SESSION['authorized'] == 1 && isset($artist) && isset($album) && isset($release_date)) {
        // Because this runs from a subdir /root/templates
        $root = str_replace('templates', '', dirname(__FILE__));
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
            'publish_date' => $publish_date
        );
        $db->run($statement, $params);

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
