<?php

    $api = 'api/v1/shopitems';
    $shop_list = file_get_contents(SERVER_URL . $api);

    $shopitems = json_decode($shop_list, true); // true makes an array
    echo '<div class="container-fluid">';
    foreach($shopitems as $shop) {
        include('./templates/partials/shop.php');
    }
    echo '</div>';

 ?>
