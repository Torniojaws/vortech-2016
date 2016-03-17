<?php

    $root = "http://" . $_SERVER['HTTP_HOST'] . "/";
    $api = 'api/v1/shows';
    $full = $root . $api;
    $shows_list_json = file_get_contents($full);

    $shows = json_decode($shows_list_json, true); // true makes an array
    echo '<div class="container-fluid">';
    foreach($shows as $show) {
        include('./templates/partials/partial-show.php');
    }
    echo '</div>';

 ?>
