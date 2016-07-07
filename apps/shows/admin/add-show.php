<?php

    $root = str_replace('apps/shows/admin', '', __DIR__);
    require_once $root.'classes/AddShow.php';

    // data
    $data['root'] = $root;
    $data['date'] = $_POST['date'];
    $data['continent'] = $_POST['continent'];
    $data['country'] = $_POST['country'];
    $data['city'] = $_POST['city'];
    $data['venue'] = $_POST['venue'];

    // Optional fields
    $data['other_bands'] = null;
    if (isset($_POST['other_bands'])) {
        $other_bands = $_POST['other_bands'];
        // eg. The Band|http://www.theband.fi
        $other_bands = array_filter(explode(PHP_EOL, $other_bands), 'strlen');
        $other_bands = implode(', ', $other_bands);
        $data['other_bands'] = $other_bands;
    }
    $data['band_comments'] = null;
    if (isset($_POST['band_comments'])) {
        $data['band_comments'] = $_POST['band_comments'];
    }
    $data['setlist'] = null;
    if (isset($_POST['setlist'])) {
        $setlist = $_POST['setlist'];
        $setlist = array_filter(explode(PHP_EOL, $setlist), 'strlen');
        $setlist = implode('|', $setlist);
        $data['setlist'] = $setlist;
    }
    $data['performers'] = null;
    if (isset($_POST['performers'])) {
        $performers = $_POST['performers'];
        $performers = array_filter(explode(PHP_EOL, $performers), 'strlen');
        $performers = implode(', ', $performers);
        $data['performers'] = $performers;
    }

    // Process the data
    $addData = new AddShow($data);
    $response = $addData->commit();

    header('Content-type: application/json');
    echo json_encode($response);
