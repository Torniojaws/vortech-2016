<?php

    require_once 'classes/Admin.php';
    $admin = new Admin();

    if ($admin->isLoggedIn()) {
        echo 'You are logged in as Admin. Have fun!';
        $admin->showLogoutButton();
    } else {
        $admin->showLoginForm();
    }
