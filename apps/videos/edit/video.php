<?php

    $root = str_replace('apps/videos/edit', '', __DIR__);
    require_once $root.'classes/EditValue.php';

    $category = 'videos';
    $edit = new EditValue($_POST, $category, $root);
    $response = $edit->commitEdit();

    if ($response['status'] == 'success') {
        echo $_POST['value'];
    } else {
        echo 'Failed to update! '.$response['message'].$_POST['value'];
    }
