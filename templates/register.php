<?php

    require_once 'classes/User.php';
    $user = new User();

    if ($user->isLoggedIn()) {
        echo 'You are logged in as <strong>'.$user->getName().'</strong> - Have fun!';
        $user->showLogoutButton();
    } else {
        $user->showRegistrationForm();
    }
