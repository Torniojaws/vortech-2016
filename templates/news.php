<?php

    $api = 'api/v1/news';
    $news_list_json = file_get_contents(SERVER_URL . $api);

    $newsitems = json_decode($news_list_json, true); // true makes an array
    echo '<div class="container-fluid">';
    foreach($newsitems as $news) {
        include('./templates/partials/news.php');
    }
    echo '</div>';

 ?>
