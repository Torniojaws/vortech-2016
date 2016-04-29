<?php

    require_once 'classes/User.php';
    require_once 'classes/Admin.php';
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
