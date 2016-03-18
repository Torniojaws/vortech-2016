<?php

    $api = 'api/v1/shop';
    $news_list_json = file_get_contents(SERVER_URL . $api);

    $newsitems = json_decode($news_list_json, true); // true makes an array
    echo '<div class="container-fluid">';
        echo '<p>Shop will probably have PayPal stuff from DB';
    foreach($newsitems as $news) {
        include('./templates/partials/shop.php');
    }
    echo '</div>';

 ?>
