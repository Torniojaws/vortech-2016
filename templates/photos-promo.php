<?php

    $api = 'api/v1/photos/promo';
    $photos_list_json = file_get_contents(SERVER_URL . $api);

    echo "Promo photos";

    $photos = json_decode($photos_list_json, true); // true makes an array
    echo '<div class="container-fluid">';
    $counter = 1;
    # $last = count($photos);
    foreach($photos as $photo) {

        // To allow fake floating of Bootstrap columns
        if($counter == 1 || $counter % 4 == 0) {
            echo '<div class="row">';
        }
        include('./templates/partials/photo.php');
        if($counter % 4 == 0) {
            echo '</div>';
        }
        $counter++;
    }
    echo '</div>';

 ?>
