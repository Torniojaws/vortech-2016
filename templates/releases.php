<?php

    $api = 'api/v1/releases';
    $releases_list_json = file_get_contents(SERVER_URL . $api);

    $releases = json_decode($releases_list_json, true); // true makes an array
    echo '<div class="container-fluid">';
    foreach($releases as $release) {
        $songlist = "api/v1/releases/" . $release["id"] . "/songs";
        $songs_list_json = file_get_contents(SERVER_URL . $songlist);
        $songs = json_decode($songs_list_json, true);
        include('./templates/partials/release.php');
    }
    echo '</div>';

 ?>
