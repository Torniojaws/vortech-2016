<?php

    session_start();

    class AdminTest extends PHPUnit_Framework_TestCase
    {
        public function testSessionSetStatusIsCorrectForExistingSession()
        {
            // Setup
            $_SESSION['testValue'] = 123;

            // Test
            if (isset($_SESSION['testValue']) && $_SESSION['testValue'] == 123) {
                $status = 'ok';
            } else {
                $status = 'not';
            }

            $this->assertEquals('ok', $status);
        }

        // This test must come last because it destroys the session by design
        public function testSessionSetStatusIsCorrectForNoSession()
        {
            // Setup
            if (isset($_SESSION)) {
                session_destroy();
            }

            // Test
            if (isset($_SESSION['testValue']) && $_SESSION['testValue'] == 123) {
                $status = 'logged';
            } else {
                $status = 'not';
            }

            $this->assertEquals('not', $status);
        }
    }
