<?php

    class Database
    {
        private $driver;
        private $host;
        private $dbname;
        private $charset;
        private $user;
        private $pass;
        public $last_action_successful;

        public function __construct()
        {
            // Depending on Dev location it is "localhost:5656/" or "/vagrant/v"
            $realpath = realpath($_SERVER['DOCUMENT_ROOT'].'/');
            $root = str_replace('//', '/', $realpath);
            $config = parse_ini_file($root.'/api/db_config.ini', true);

            // mariaDB at the moment
            $this->driver = $config['database']['driver'];
            $this->host = $config['database']['host'];
            $this->dbname = $config['database']['schema'];
            $this->charset = $config['database']['charset'];
            $this->user = $config['database']['username'];
            $this->pass = $config['database']['password'];
            $this->last_action_successful = false;
        }

        public function connect()
        {
            try {
                $this->pdo = new PDO(
                    "$this->driver:host=$this->host; dbname=$this->dbname; charset=$this->charset",
                    $this->user,
                    $this->pass
                );
                // For added security with MySQL / MariaDB
                $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $exception) {
                echo $exception;
            }
        }

        public function run($statement, $params)
        {
            try {
                $this->query = $this->pdo->prepare($statement);
                if ($this->query->execute($params)) {
                    $this->last_action_successful = true;
                } else {
                    $this->last_action_successful = false;
                }

                return $this->query->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $err) {
                echo $err;
            }
        }

        public function close()
        {
            $this->pdo = null;
        }

        public function getError()
        {
            echo $this->pdo->errorCode().'<br />';
            print_r($this->pdo->errorInfo());
            echo $this->query->errorCode().'<br />';
            print_r($this->query->errorInfo());
        }

        public function querySuccessful()
        {
            return $this->last_action_successful;
        }
    }
