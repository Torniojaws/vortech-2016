<?php

    if ($_SESSION['authorized'] == 1) {
        include './apps/news/admin/add-news-modal.php';
    }

    $uri = $_SERVER['REQUEST_URI'];
    // GET parameters, eg. www.example.com/page?param=1
    list($uri, $params) = explode('?', $uri);

    $api = 'api/v1/news';
    if (isset($params)) {
        $api .= '?'.$params;
    }
    $news_list_json = file_get_contents(SERVER_URL.$api);

    // true makes an array
    $newsitems = json_decode($news_list_json, true);
    echo '<div class="container-fluid">';
    foreach ($newsitems as $news) {
        include './apps/news/partials/news-item.php';
    }
    echo '</div>';
