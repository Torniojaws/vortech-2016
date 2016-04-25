<?php

    require_once 'classes/User.php';
    $user = new User();

    if ($user->isLoggedIn()) {
        echo 'Hello, <strong>'.$user->getName().'</strong>!';

        include 'templates/forms/update-profile.php';

        $user->showLogoutButton();
    } else {
        $user->showLoginForm();
    }
