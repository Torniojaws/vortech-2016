<?php

    $api = 'api/v1/guestbook';
    $guestbook_list_json = file_get_contents(SERVER_URL.$api);

    // User photos
    $photo_api = 'api/v1/photos/user-photos';
    $photos_list = file_get_contents(SERVER_URL.$photo_api);
    $photos = json_decode($photos_list, true);

    // true makes an array
    $guestbook_items = json_decode($guestbook_list_json, true);
    echo '<div class="container-fluid">';
    foreach ($guestbook_items as $guest) {

        // 0-index conversion with - 1
        $current_userid = $guest['userid'] - 1;
        $user_photo = $photos[$current_userid];

        include './apps/guestbook/partials/post.php';
    }
    echo '</div>';
