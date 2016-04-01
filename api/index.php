<?php

    header('Content-Type: application/json');
    require_once('classes/query.php');
    require_once('classes/database.php');

    // Generate the SQL
    $query = new Query($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], file_get_contents('php://input'));
    $statement = $query->getResult()['statement'];
    $params = $query->getResult()['params'];

    // Connect to DB
    $db = new Database();
    $db->connect();

    // Run the prepared query
    $results = $db->run($statement, $params);

    // and return the results
    if($results != null)
    {
        $json = json_encode($results, JSON_NUMERIC_CHECK);
    }
    else
    {
        $json = json_encode(array("Error" => "No results"));
    }
    
    echo $json;
