<?php

    require_once 'constants.php';

    class DatabaseTest extends PHPUnit_Framework_TestCase
    {
        public function __construct()
        {
            $config = parse_ini_file('tests/db_config.ini', true);
            $this->driver = $config['database']['driver'];
            $this->host = $config['database']['host'];
            $this->dbname = $config['database']['schema'];
            $this->charset = $config['database']['charset'];
            $this->user = $config['database']['username'];
            $this->pass = $config['database']['password'];
        }

        public function testConfigFileExists()
        {
            $config = 'tests/db_config.ini';
            $this->assertFileExists($config);
        }

        public function testDatabaseConnection()
        {
            try {
                $errors = 0;
                $pdo = new PDO(
                    "$this->driver:host=$this->host; dbname=$this->dbname;charset=$this->charset",
                    $this->user,
                    $this->pass
                );
            } catch (PDOException $exception) {
                $errors += 1;
            }
            $this->assertEquals(0, $errors);
        }

        public function testDatabaseContainsAllRequiredTables()
        {
            $requiredTables = array(
                'guestbook',
                'guestbook_comments',
                'news',
                'news_comments',
                'performers',
                'photo_albums',
                'photo_categories',
                'photo_comments',
                'photos',
                'release_comments',
                'releases',
                'shop_categories',
                'shop_items',
                'shows',
                'songs',
                'user_access_levels',
                'users',
                'video_categories',
                'videos',
                'visitor_count',
            );
            $errors = 0;
            $pdo = new PDO(
                "$this->driver:host=$this->host; dbname=$this->dbname;charset=$this->charset",
                $this->user,
                $this->pass
            );
            foreach ($requiredTables as $table) {
                $query = $pdo->prepare("SELECT 1 FROM $table");
                $query->execute();
                if ($query->fetch() == false) {
                    $errors += 1;
                }
            }

            $this->assertEquals(0, $errors);
        }

        public function testNewsAPIReturnsExpectedData()
        {
            $pdo = new PDO(
                "$this->driver:host=$this->host; dbname=$this->dbname;charset=$this->charset",
                $this->user,
                $this->pass
            );
            $query = $pdo->prepare('SELECT * FROM news WHERE id = 1');
            $query->execute();
            $data = $query->fetchAll(PDO::FETCH_ASSOC);

            $this->assertEquals('Teki', $data[0]['title']);
        }
    }
