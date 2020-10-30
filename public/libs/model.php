<?php

namespace app\libs\model;
use app\libs\database\query\Query;

    class Model {

        public $query;

        function __construct() {
            $this->query = new Query();
        }

        function getQuery() {
            return $this->query;
        }
    }

?>