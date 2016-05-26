<?php

    session_start();

    $root = str_replace('apps/news/forms', '', __DIR__);
    require_once $root.'classes/UserComment.php';
    $params = array(
        'user_id' => $_POST['user_id'],
        'display_name' => $_POST['display_name'],
        'category' => 'news', // Always change this when you reuse!
        'comment' => $_POST['comment'],
        'comment_target_id' => $_POST['news_id'],
        'comment_subid' => $_POST['comment_subid'],
        'modal_id' => $_POST['news_id'],
        'root' => $root,
        'category_subid' => null,
    );
    $comment = new UserComment($params);
    $comment->commitPost();
