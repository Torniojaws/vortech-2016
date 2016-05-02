<?php

    session_start();

    class User
    {
        private $loggedIn = false;
        private $name;
        private $avatar;
        private $access_level;
        private $caption;

        public function __construct()
        {
            if (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] == 1) {
                $this->loggedIn = true;
                $this->name = $_SESSION['username'];
            }
        }

        public function isLoggedIn()
        {
            return $this->loggedIn;
        }

        public function showLoginForm()
        {
            require './apps/main/partials/login.php';
        }

        public function showLogoutButton()
        {
            require './apps/main/partials/logout.php';
        }

        public function showRegistrationForm()
        {
            require './apps/main/partials/register.php';
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
