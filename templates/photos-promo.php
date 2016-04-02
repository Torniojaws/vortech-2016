<?php

    $api = 'api/v1/photos/promo';
    $photos_list_json = file_get_contents(SERVER_URL.$api);

    echo 'Promo photos';

    // true makes an array
    $photos = json_decode($photos_list_json, true);
    echo '<div class="container-fluid">';
    $counter = 1;
    foreach ($photos as $photo) {
        // To allow fake floating of Bootstrap columns
        if ($counter == 1 || $counter % 4 == 0) {
            echo '<div class="row">';
        }
        include './templates/partials/photo.php';
        if ($counter % 4 == 0) {
            echo '</div><hr />';
        }
        ++$counter;
    }
    echo '</div>';
