<?php

    header('Content-Type: application/json');
    require_once 'classes/Query.php';
    require_once 'classes/Database.php';

    // Generate the SQL
    $query = new Query(
        $_SERVER['REQUEST_METHOD'],
        $_SERVER['REQUEST_URI'],
        file_get_contents('php://input')
    );
    $statement = $query->getResult()['statement'];
    $params = $query->getResult()['params'];

    // Connect to DB
    $db = new Database();
    $db->connect();

    // Run the prepared query if query is not empty
    if (empty($statement) and empty($params)) {
        $results = null;
    } else {
        $results = $db->run($statement, $params);
    }

    // and print the results as JSON.
    // Note that this is never going to be used by prepared INSERT statements, so simply checking
    // if the result is null is enough. The expected data must be valid anyway. If ever needed,
    // you can also use the boolean querySuccessful() method of the $db instance.
    if ($results != null) {
        $json = json_encode($results, JSON_NUMERIC_CHECK);
    } else {
        $json = json_encode(array($results));
    }

    echo $json;
