<?php

    session_start();

    class User
    {
        private $loggedIn = false;
        private $name;
        private $avatar;

        public function __construct()
        {
            if (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] == 1) {
                $this->loggedIn = true;
            }
        }

        public function isLoggedIn()
        {
            return $this->loggedIn;
        }

        public function showLoginForm()
        {
            require './templates/partials/login.php';
        }

        public function showLogoutButton()
        {
            require './templates/partials/logout.php';
        }

        public function showRegistrationForm()
        {
            require './templates/partials/register.php';
        }

        public function logout()
        {
            if ($this->isLoggedIn() == false) {
                echo 'Already logged out';
            } else {
                $_SESSION = array();
                session_destroy();
                $this->loggedIn = false;
            }
        }
    }
