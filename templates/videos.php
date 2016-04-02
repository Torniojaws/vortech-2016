<?php

    $api = 'api/v1/videos';
    $videos_list = file_get_contents(SERVER_URL.$api);

    // true makes an array
    $videos = json_decode($videos_list, true);
    echo '<div class="container-fluid">';
    foreach ($videos as $video) {
        include './templates/partials/video.php';
    }
    echo '</div>';
