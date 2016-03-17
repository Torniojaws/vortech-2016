<?php

    $root = "http://" . $_SERVER['HTTP_HOST'] . "/";
    $api = 'api/v1/guestbook';
    $full = $root . $api;
    $guestbook_list_json = file_get_contents($full);

    $guestbook_items = json_decode($guestbook_list_json, true); // true makes an array
    echo '<div class="container-fluid">';
    foreach($guestbook_items as $item) {
        include('./templates/partials/partial-guestbook-post.php');
    }
    echo '</div>';

 ?>
