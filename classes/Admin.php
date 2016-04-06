<?php

    session_start();

    class Admin
    {
        private $loggedIn = false;

        public function __construct()
        {
            if (isset($_SESSION['authorized']) && $_SESSION['authorized'] == 1) {
                $this->loggedIn = true;
            }
        }

        public function isLoggedIn()
        {
            return $this->loggedIn;
        }

        public function showLoginForm()
        {
            require './templates/partials/admin-login.php';
        }

        public function showLogoutButton()
        {
            require './templates/partials/admin-logout.php';
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
