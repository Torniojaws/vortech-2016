<?php

    $root = "http://" . $_SERVER['HTTP_HOST'] . "/";
    $api = 'api/v1/photos/live';
    $full = $root . $api;
    $photos_list_json = file_get_contents($full);

    echo "Live photos";

    $photos = json_decode($photos_list_json, true); // true makes an array
    echo '<div class="container-fluid">';
    foreach($photos as $photo) {
        include('./templates/partials/photo.php');
    }
    echo '</div>';

 ?>
