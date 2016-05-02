<?php

    if ($_SESSION['authorized'] == 1) {
        include './apps/videos/admin/add-video-modal.php';
    }

    $api = 'api/v1/videos';
    $videos_list = file_get_contents(SERVER_URL.$api);

    // true makes an array
    $videos = json_decode($videos_list, true);
    echo '<div class="container-fluid">';
    foreach ($videos as $video) {
        include './apps/videos/partials/video.php';
    }
    echo '</div>';
