<?php

    session_start();

    if ($_SESSION['authorized'] == 1) {
        include './apps/releases/admin/add-release-modal.php';
    }

    $api = 'api/v1/releases';
    $releases_list_json = file_get_contents(SERVER_URL.$api);

    // true makes an array
    $releases = json_decode($releases_list_json, true);
    echo '<div class="container-fluid">';
    foreach ($releases as $release) {
        $songlist = 'api/v1/releases/'.$release['release_code'].'/songs';
        $songs_list_json = file_get_contents(SERVER_URL.$songlist);
        $songs = json_decode($songs_list_json, true);
        include './apps/releases/partials/release.php';
    }
    echo '</div>';
