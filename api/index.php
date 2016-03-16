<?php

    header('Content-Type: application/json');

    $method = $_SERVER['REQUEST_METHOD'];
    $request = $_SERVER['REQUEST_URI'];
    $input = json_decode(file_get_contents('php://input'), true);

    $host = 'localhost';
    $user = 'teejii';
    $pass = 'samppeli';
    $database = 'tech0';

    // Let's connect
    $db = mysqli_connect($host, $user, $pass, $database);
    if(!$db) {
        echo mysqli_connect_errno() . mysqli_connect_error();
    }
    mysqli_get_host_info($db);
    mysqli_set_charset($db, 'utf8');

    // Here we create the SQL query to run
    $path = $_SERVER['DOCUMENT_ROOT'] . "/";
    $file = "api/endpoint-handler.php";
    $full = $path . $file;
    ini_set("display_errors", "stdout");
    if(file_exists($full)) {
        require_once($full);
    } else {
        echo "Endpoint missing";
    }

    $sql = endpoint_list($method, $request, $input);

    // And we should get results to return as JSON
    $results = array();
    $json = '{"Result":"Empty"}';
    if($result = mysqli_query($db, mysqli_real_escape_string($db, $sql))) {
        while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $results[] = $row;
        }
        mysqli_free_result($result);
        if($results != null) {
            $json = json_encode($results, JSON_NUMERIC_CHECK);
        }
    }

    echo $json;

?>
