<?php

    if ($_SESSION['authorized'] == 1) {
        include './apps/shop/admin/add-shopitem.php';
    }

    $api = 'api/v1/shopitems';
    $shop_list = file_get_contents(SERVER_URL.$api);

    // true makes an array
    $shopitems = json_decode($shop_list, true);
    echo '<div class="container-fluid">';
    foreach ($shopitems as $shop) {
        include './apps/shop/partials/shop-item.php';
    }
    echo '</div>';
