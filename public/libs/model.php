<?php

namespace app\libs\model;
use app\libs\database\query\Query;

    class Model {

        public $query;

        function __construct() {
            $this->query = new Query();
        }

        function checkDatabase() {
            $this->query->queryCheckDB();
            $result = $this->query->fetchResult();
            return $result;
        }

        function createDatabase() {
            die('Not implemented yet');
        }

        function getQuery() {
            return $this->query;
        }
    }

?>