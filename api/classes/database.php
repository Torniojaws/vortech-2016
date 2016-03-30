<?php

    class Database
    {
        public function __construct()
        {
            $config = parse_ini_file('db_config.ini', true);
            $this->driver = $config['database']['driver']; // mariaDB at the moment
            $this->host = $config['database']['host'];
            $this->dbname = $config['database']['schema'];
            $this->charset = $config['database']['charset'];
            $this->user = $config['database']['username'];
            $this->pass = $config['database']['password'];
        }

        public function connection()
        {
            try {
                $this->pdo = new PDO("$this->driver:host=$this->host; dbname=$this->dbname;charset=$this->charset",
                                      $this->user, $this->pass);
            } catch(PDOException $exception) {
                echo $exception;
            }
        }

        public function run($statement, $params) {
            echo "Database.php running: " . $statement . " with Params: " . $params;
            $query = $this->pdo->prepare($statement);
            $query->execute($params);
        }

    }
