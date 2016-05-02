<?php

    if ($_SESSION['authorized'] == 1) {
        include './apps/shows/admin/add-show-modal.php';
    }

    $api = 'api/v1/shows';
    $shows_list_json = file_get_contents(SERVER_URL.$api);

    // true makes an array
    $shows = json_decode($shows_list_json, true);
    echo '<div class="container-fluid">';
    foreach ($shows as $show) {
        include './apps/shows/partials/show-details.php';
    }
    echo '</div>';
