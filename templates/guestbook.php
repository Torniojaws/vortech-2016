<?php

    $api = 'api/v1/guestbook';
    $guestbook_list_json = file_get_contents(SERVER_URL . $api);

    // For user avatars
    $photo_api = 'api/v1/photos';
    $photos_list = file_get_contents(SERVER_URL . $photo_api);
    $photos = json_decode($photos_list, true);

    $guestbook_items = json_decode($guestbook_list_json, true); // true makes an array
    echo '<div class="container-fluid">';
    foreach($guestbook_items as $guest) {
        $avatar = $photos[$guest['photo_id']-1]; // 0-index
        include('./templates/partials/guestbook-post.php');
    }
    echo '</div>';

 ?>
