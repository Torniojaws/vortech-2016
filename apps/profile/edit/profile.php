<?php

    $root = str_replace('apps/profile/edit', '', __DIR__);
    require_once $root.'classes/EditProfile.php';

    $edit = new EditProfile($_POST, $root);
    $response = $edit->commitEdit();

    header('Content-type: application/json');
    echo json_encode($response);
