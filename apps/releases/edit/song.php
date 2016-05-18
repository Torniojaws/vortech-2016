<?php

    $root = str_replace('apps/releases/edit', '', __DIR__);
    require_once $root.'classes/EditSong.php';

    $edit = new EditSong($_POST, $root);
    $response = $edit->commitEdit();

    if ($response['status'] == 'success') {
        echo $_POST['value'];
    } else {
        echo 'Failed to update! '.$response['message'].$_POST['value'];
    }
