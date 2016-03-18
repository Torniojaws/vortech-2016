<?php

    $api = 'api/v1/photos/misc';
    $photos_list_json = file_get_contents(SERVER_URL . $api);

    echo "Misc photos";

    $photos = json_decode($photos_list_json, true); // true makes an array
    echo '<div class="container-fluid">';
    foreach($photos as $photo) {
        include('./templates/partials/photo.php');
    }
    echo '</div>';

 ?>
