<?php

    $api = 'api/v1/photos';
    $photos_list_json = file_get_contents(SERVER_URL.$api);

    // true makes an array
    $photos = json_decode($photos_list_json, true);
    $counter = 0;
    echo '<div class="container-fluid">';
    foreach ($photos as $photo) {
        ++$counter;
        // Some photo albums will not be shown, eg. user avatars, band members
        if ($photo['show_in_gallery'] == 0) {
            continue;
        }
        // To allow fake floating of Bootstrap columns
        if ($counter == 1 || $counter % 3 == 0) {
            echo '<div class="row">';
        }
        include './templates/partials/photo.php';
        if ($counter % 3 == 0) {
            echo '</div><hr />';
        }

    }
    echo '</div>';
