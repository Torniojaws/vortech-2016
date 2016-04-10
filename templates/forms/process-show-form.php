<?php

    session_start();

    // Mandatory fields
    $date = $_POST['date']; # yyyy-mm-dd hh:mm:ss
    $continent = $_POST['continent'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $venue = $_POST['venue'];

    // Optional fields
    $other_bands = null;
    if (isset($_POST['other_bands'])) {
        $other_bands = $_POST['other_bands'];
    }
    $band_comments = null;
    if (isset($_POST['band_comments'])) {
        $band_comments = $_POST['band_comments'];
    }
    $setlist = null;
    if (isset($_POST['setlist'])) {
        $setlist = $_POST['setlist'];
    }
    $performers = null;
    if (isset($_POST['performers'])) {
        $performers = $_POST['performers'];
    }

    // Other bands are a newline-separated list with pipe delimiter for website
    // eg.
    // The Band|http://www.theband.fi
    // Another Band|http://www.website.com
    // But in the DB they will be comma separated
    if (isset($other_bands)) {
        $other_bands = array_filter(explode(PHP_EOL, $other_bands), 'strlen');
        $other_bands = implode(', ', $other_bands);
    }

    if (isset($setlist)) {
        $setlist = array_filter(explode(PHP_EOL, $setlist), 'strlen');
        $setlist = implode('|', $setlist);
    }

    if (isset($performers)) {
        $performers = array_filter(explode(PHP_EOL, $performers), 'strlen');
        $performers = implode(', ', $performers);
    }

    if ($_SESSION['authorized'] == 1 && isset($date) && isset($continent) && isset($country)
        && isset($city) && isset($venue)) {
        // Because this runs from a subdir /root/templates/forms
        $root = str_replace('templates/forms', '', dirname(__FILE__));
        require_once $root.'/api/classes/Database.php';

        $db = new Database();
        $db->connect();

        $statement = 'INSERT INTO shows VALUES(
            0,
            :show_date,
            :continent,
            :country,
            :city,
            :venue,
            :other_bands,
            :band_comments,
            :setlist,
            :performers
        )';
        $params = array(
            'show_date' => $date,
            'continent' => $continent,
            'country' => $country,
            'city' => $city,
            'venue' => $venue,
            'other_bands' => $other_bands,
            'band_comments' => $band_comments,
            'setlist' => $setlist,
            'performers' => $performers,
        );
        var_dump($params);
        $db->run($statement, $params);
        $db->close();

        if ($db->querySuccessful()) {
            $response['status'] = 'success';
            $response['message'] = 'Show added to DB';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to add show to DB!';
        }
    } else {
        if (isset($_SESSION['authorized']) == false) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Missing mandatory show details';
        }
    }

    header('Content-type: application/json');
    echo json_encode($response);
