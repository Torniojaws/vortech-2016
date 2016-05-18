<?php

    $root = str_replace('apps/shows/edit', '', __DIR__);
    require_once $root.'classes/EditShow.php';

    $edit = new EditShow($_POST, $root);
    $response = $edit->commitEdit();

    header('Content-type: application/json');
    echo json_encode($response);
