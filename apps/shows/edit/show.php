<?php

    session_start();
    require_once '../../../constants.php';

    /*
        From show details, we expect to edit any value
    */
    if (isset($_SESSION) && $_SESSION['authorized'] == 1 && isset($_POST)) {
        $id = $_POST['id'];
        $date = $_POST['date'];
        $continent = $_POST['continent'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $venue = $_POST['venue'];
        $other_bands = $_POST['bands'];
        $band_comments = $_POST['band-comments'];
        $setlist = $_POST['setlist'];
        $performers = $_POST['performers'];

        // PUT http://www.vortechmusic.com/api/v1/shopitems/123
        $api = SERVER_URL.'api/v1/shows/'.$id;

        // Generate the PUT request
        $data = array(
            'id' => $id,
            'date' => $date,
            'continent' => $continent,
            'country' => $country,
            'city' => $city,
            'venue' => $venue,
            'other_bands' => $other_bands,
            'band_comments' => $band_comments,
            'setlist' => $setlist,
            'performers' => $performers,
        );
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'PUT',
                'content' => http_build_query($data),
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($api, false, $context);
        if ($result === false) {
            $response['status'] = 'error';
            $response['message'] = 'Could not update to DB';
        } else {
            $response['status'] = 'success';
            $response['message'] = 'Updated DB successfully';
        }
    } else {
        if (isset($_SESSION['authorized']) == false) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Missing required data';
        }
    }

    header('Content-type: application/json');
    echo json_encode($response);
