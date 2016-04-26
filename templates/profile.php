<?php

    require_once 'classes/User.php';
    $user = new User();

    if ($user->isLoggedIn()) {
        $user->showLogoutButton();
        include 'templates/partials/profile.php';
    } else {
        $user->showLoginForm();
    }
