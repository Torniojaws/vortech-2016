<?php

    # header('Content-Type: application/json');

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
        echo "ERROR! ";
        echo mysqli_connect_errno();
        echo " ";
        echo mysqli_connect_error();
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
    if($sql != "") {
        $result = mysqli_query($db, $sql) or die(mysqli_error());
        $result = json_encode($result);
    } else {
        $result = '{"Result":"Empty"}';
    }

    echo $result;

?>
