<?php

    if ($_SESSION['authorized'] == 1) {
        include './templates/partials/admin/add-photos.php';
    }

    $api = 'api/v1/photos/live';
    $photos_list_json = file_get_contents(SERVER_URL.$api);

    echo 'Live photos';

    // true makes an array
    $photos = json_decode($photos_list_json, true);
    echo '<div class="container-fluid">';
    foreach ($photos as $photo) {
        include './templates/partials/photo.php';
    }
    echo '</div>';
