<?php

    $api = 'api/v1/guestbook';
    $guestbook_list_json = file_get_contents(SERVER_URL.$api);

    // For user avatars
    $photo_api = 'api/v1/photos';
    $photos_list = file_get_contents(SERVER_URL.$photo_api);
    $photos = json_decode($photos_list, true);

    // true makes an array
    $guestbook_items = json_decode($guestbook_list_json, true);
    echo '<div class="container-fluid">';
    foreach ($guestbook_items as $guest) {
        // 0-index conversion
        $avatar = $photos[$guest['photo_id'] - 1];
        include './templates/partials/guestbook-post.php';
    }
    echo '</div>';
