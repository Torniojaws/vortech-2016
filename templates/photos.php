<?php

    $api = 'api/v1/photos';
    $photos_list_json = file_get_contents(SERVER_URL . $api);

    $photos = json_decode($photos_list_json, true); // true makes an array
    $counter = 1;
    echo '<div class="container-fluid">';
    foreach($photos as $photo) {
        // To allow fake floating of Bootstrap columns
        if($counter == 1 || $counter % 3 == 0) {
            echo '<div class="row">';
        }
        include('./templates/partials/photo.php');
        if($counter % 3 == 0) {
            echo '</div>';
        }
        $counter++;
    }
    echo '</div>';

 ?>
