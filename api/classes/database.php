<?php

    class Database
    {
        public function __construct()
        {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $config = parse_ini_file($root.'api/db_config.ini', true);
            // mariaDB at the moment
            $this->driver = $config['database']['driver'];
            $this->host = $config['database']['host'];
            $this->dbname = $config['database']['schema'];
            $this->charset = $config['database']['charset'];
            $this->user = $config['database']['username'];
            $this->pass = $config['database']['password'];
        }

        public function connect()
        {
            try {
                $this->pdo = new PDO(
                    "$this->driver:host=$this->host; dbname=$this->dbname; charset=$this->charset",
                    $this->user,
                    $this->pass
                );
            } catch (PDOException $exception) {
                echo $exception;
            }
        }

        public function run($statement, $params)
        {
            try {
                $query = $this->pdo->prepare($statement);
                $query->execute($params);

                return $query->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $err) {
                echo $err;
            }
        }
    }
