<?php

    $root = str_replace('apps/news/edit', '', __DIR__);
    require_once $root.'classes/EditValue.php';

    $category = 'news';
    $edit = new EditValue($_POST, $category, $root);
    $response = $edit->commitEdit();

    if ($response['status'] == 'success') {
        echo $_POST['value'];
    } else {
        echo 'Failed to update! '.$response['message'].$_POST['value'];
    }
