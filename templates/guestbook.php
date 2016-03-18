<?php

    $api = 'api/v1/guestbook';
    $guestbook_list_json = file_get_contents(SERVER_URL . $api);

    $guestbook_items = json_decode($guestbook_list_json, true); // true makes an array
    echo '<div class="container-fluid">';
    echo "Guestbook will most certainly be DB";
    foreach($guestbook_items as $item) {
        include('./templates/partials/guestbook-post.php');
    }
    echo '</div>';

 ?>