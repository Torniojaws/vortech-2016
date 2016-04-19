<?php

    session_start();
    require_once '../../constants.php';

    /*
        From guestbook comments, we expect to edit just the admin comment
    */
    if (isset($_SESSION) && $_SESSION['authorized'] == 1 && isset($_POST)) {
        list($field, $id) = explode('-', $_POST['id']);
        $new_value = $_POST['value'];

        // PUT http://www.vortechmusic.com/api/v1/guestbook/123
        $api = SERVER_URL.'api/v1/guestbook/'.$id;

        // Generate the PUT request
        $data = array(
            'id' => $id,
            'new_value' => $new_value,
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

    if ($response['status'] == 'success') {
        echo $new_value;
    } else {
        echo $_POST['value'];
    }
