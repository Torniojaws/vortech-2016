<?php

    $root = str_replace('/apps/profile', '', __DIR__);
    require_once $root.'/classes/User.php';
    require_once $root.'/classes/Admin.php';
    $user = new User();
    $admin = new Admin();

    if ($user->isLoggedIn()) {
        $user->showLogoutButton();
        include 'apps/profile/partials/profile.php';
    } elseif ($admin->isLoggedIn()) {
        $admin->showLogoutButton();
        include 'apps/profile/partials/profile.php';
    } else {
        $user->showLoginForm();
    }
