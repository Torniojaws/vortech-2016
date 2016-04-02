<?php

    $api = 'api/v1/shopitems';
    $shop_list = file_get_contents(SERVER_URL.$api);

    // true makes an array
    $shopitems = json_decode($shop_list, true);
    echo '<div class="container-fluid">';
    foreach ($shopitems as $shop) {
        include './templates/partials/shop.php';
    }
    echo '</div>';
