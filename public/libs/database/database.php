<?php

namespace app\libs\database\database;
require_once('../vendor/autoload.php');
require_once('./libs/database/query.php');

    class Connect {

        public static function connection() {

            $host = getenv('DDBB_HOST');
            $username = getenv('DDBB_USER');
            $passwd = getenv('DDBB_PASSWORD');
            $dbname = getenv('DDBB_DATABASE');
            $port = getenv('DDBB_PORT');
            $connection = new \mysqli($host, $username, $passwd, $dbname, $port);
            mysqli_autocommit($connection, FALSE);
            return $connection;
        }
        
    }

?>