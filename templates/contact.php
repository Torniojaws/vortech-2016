<?php

    $root = "http://" . $_SERVER['HTTP_HOST'] . "/";
    $api = 'api/v1/releases';
    $full = $root . $api;
    $releases_list_json = file_get_contents($full);

    $releases = json_decode($releases_list_json, true); // true makes an array
    echo '<div class="container-fluid">';
    foreach($releases as $release) {
        $songlist = "api/v1/releases/" . $release["id"] . "/songs";
        $songs_list_json = file_get_contents($root . $songlist);
        # $songs_list_json = '[{"id":1,"album_code":"ABC","title":"Test","duration":"00:03:17"},{"id":2,"album_code":"ABC","title":"Jep","duration":"00:04:17"}]';
        $songs = json_decode($songs_list_json, true);

        include('./templates/partials/contact.php');
    }
    echo '</div>';

 ?>
