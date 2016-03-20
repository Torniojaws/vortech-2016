<?php

    $api = 'api/v1/members';
    $members_list_json = file_get_contents(SERVER_URL . $api);

    $members = json_decode($members_list_json, true); // true makes an array
    echo '<div class="container-fluid">';
    foreach($members as $member) {
        $photo_api = 'api/v1/photos/' . $member['photo_id'];
        $photo = file_get_contents(SERVER_URL . $photo_api);
        $photo = json_decode($photo, true);
        include('./templates/partials/bio.php');
    }
    echo '</div>';

 ?>
