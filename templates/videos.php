<?php

    $api = 'api/v1/videos';
    $releases_list_json = file_get_contents(SERVER_URL . $api);

    $releases = json_decode($releases_list_json, true); // true makes an array
    echo '<div class="container-fluid">';
    echo "Video links from DB fo 'sho";
    foreach($releases as $release) {
        $songlist = "api/v1/releases/" . $release["id"] . "/songs";
        $songs_list_json = file_get_contents($root . $songlist);
        # $songs_list_json = '[{"id":1,"album_code":"ABC","title":"Test","duration":"00:03:17"},{"id":2,"album_code":"ABC","title":"Jep","duration":"00:04:17"}]';
        $songs = json_decode($songs_list_json, true);

        include('./templates/partials/video.php');
    }
    echo '</div>';

 ?>
