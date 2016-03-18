<?php

    $api = 'api/v1/shows';
    $shows_list_json = file_get_contents(SERVER_URL . $api);

    $shows = json_decode($shows_list_json, true); // true makes an array
    echo '<div class="container-fluid">';
    foreach($shows as $show) {
        include('./templates/partials/show.php');
    }
    echo '</div>';

 ?>
