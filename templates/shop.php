<?php

    $root = "http://" . $_SERVER['HTTP_HOST'] . "/";
    $api = 'api/v1/shop';
    $full = $root . $api;
    $news_list_json = file_get_contents($full);

    $newsitems = json_decode($news_list_json, true); // true makes an array
    echo '<div class="container-fluid">';
        echo '<p>Shop will probably have PayPal stuff from DB';
    foreach($newsitems as $news) {
        include('./templates/partials/shop.php');
    }
    echo '</div>';

 ?>
