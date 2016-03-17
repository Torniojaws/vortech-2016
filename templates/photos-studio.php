<?php

    $root = "http://" . $_SERVER['HTTP_HOST'] . "/";
    $api = 'api/v1/photos';
    $full = $root . $api;
    $photos_list_json = file_get_contents($full);

    echo "Studio photos";

    $photos = json_decode($photos_list_json, true); // true makes an array
    echo '<div class="container-fluid">';
    foreach($photos as $photo) {
        include('./templates/partials/partial-photo.php');
    }
    echo '</div>';

 ?>
