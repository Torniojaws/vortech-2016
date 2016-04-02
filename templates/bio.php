<?php

    $api = 'api/v1/members';
    $members_list_json = file_get_contents(SERVER_URL.$api);

    // json_decode() with param2 as "true" converts the data to an array
    $members = json_decode($members_list_json, true);
    echo '<div class="container-fluid">';
    foreach ($members as $member) {
        $photo_api = 'api/v1/photos/'.$member['photo_id'];
        $photo = file_get_contents(SERVER_URL.$photo_api);
        $photo = json_decode($photo, true);
        // The array will always contain just one item, so we'll use the first
        $photo = $photo[0];
        include './templates/partials/bio.php';
    }
    echo '</div>';
