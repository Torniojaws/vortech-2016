<?php

    session_start();

    $root = str_replace('apps/shop/forms', '', __DIR__);
    require_once $root.'classes/UserCommentWithCategory.php';
    $params = array(
        'user_id' => $_POST['user_id'],
        'display_name' => $_SESSION['display_name'],
        'category' => 'shopitems', // Always change this when you reuse!
        'comment' => $_POST['comment'],
        'comment_target_id' => $_POST['shopitem_id'],
        'comment_subid' => $_POST['comment_subid'],
        'modal_id' => $_POST['shopitem_id'],
        'root' => $root,
        'category_subid' => $_POST['category_comment_subid'],
    );
    $comment = new UserCommentWithCategory($params);
    $comment->commitPost();
