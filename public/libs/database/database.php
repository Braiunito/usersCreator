<?php

namespace app\libs\database\database;
require_once('../vendor/autoload.php');
require_once('./libs/database/query.php');

    class Connect {

        public static function connection() {

            $dotenv = \Dotenv\Dotenv::createImmutable('../');
            $dotenv->load();
            
            $dotenv = \Dotenv\Dotenv::createImmutable('../');
            $dotenv->load();        
            $host = $_ENV['DDBB_HOST']; 
            $username = $_ENV['DDBB_USER'];
            $passwd = $_ENV['DDBB_PASSWORD'];
            $dbname = $_ENV['DDBB_DATABASE'];
            $port = $_ENV['DDBB_PORT'];
            $connection = new \mysqli($host, $username, $passwd, $dbname, $port);
            mysqli_autocommit($connection, FALSE);
            return $connection;
        }
        
    }

?>