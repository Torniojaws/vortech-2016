<?php

    #header('Content-Type: application/json');
    require_once('classes/query.php');
    require_once('classes/database.php');

    // Generate the SQL
    $query = new Query($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], file_get_contents('php://input'));

    // Connect to DB
    $db = new Database();
    $db->connection();

    // Run the query
    $results = $db->connection()->run($query['statement'], $query['params']);

    // and return the results
    if($results != null) {
        echo "API index received data: " . $results . "<br />";
        $json = json_encode($results, JSON_NUMERIC_CHECK);
    } else {
        echo "API index received no data <br /> ";
        $json = json_encode(array("Error" => "No results"));
    }
    echo $json;
