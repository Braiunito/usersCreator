<?php

namespace app\libs\database\query;
use app\libs\database\database\Connect;

    class Query {

        private $query;
        private $result;

        function __construct() {
            $this->query = array();
            $this->result = array();
        }

        private function queryGet($sql) {
            $connection = Connect::connection();
            $result = false;
            try {
                $query = $connection->query($sql);
            } catch (Exception $e) {
                throw ($e);
            }
            if ($query) {
                while ($row = $query->fetch_assoc()) {
                    $result[] = $row;
                }
                $connection->close();
                return $result;
            }
            return false;
        }

        private function queryAlter($sql) {
            $connection = Connect::connection();
            try {
                $query = $connection->query($sql); 
            } catch (Exception $e) {
                $connection->rollback();
                return false;
            }
            $connection->commit();
            $connection->close();
            return true;
        }
        function fetchResult() {
            return $this->result;
        }

        // ToDo check case with no database
        function queryCheckDB() {
            $database = getenv('DDBB_DATABASE');
            $sql = "CREATE DATABASE IF NOT EXISTS '{$database}';";
            $result = $this->queryAlter($sql);
            $result = ($result) ? true : false;
            $this->result = $result;
        }

        function queryCheckTable($table) {
            $database = getenv('DDBB_DATABASE');
            $sql = "SELECT * FROM information_schema.tables WHERE table_schema = '{$database}' AND table_name = '{$table}';";
            $result = $this->queryGet($sql);
            $result = ($result) ? true : false;
            $this->result = $result;
        }

        function queryInsertRow($table, $columns, $values) {
            $cols = implode(',', $columns);
            $vals = array();
            foreach ($values as $key => $value) {
                array_push($vals, "'{$value}'");
            }
            $vals = implode(', ', $vals);
            $sql = "INSERT INTO {$table} ({$cols}) VALUES ({$vals});";
            $result = $this->queryAlter($sql);
            $this->result = $result;
        }

        function queryDeleteRow($table, $column, $value) {
            $sql = "DELETE FROM {$table} WHERE {$column}='{$value}';";
            $result = $this->queryAlter($sql);
            $this->result = $result;
        }

        /**
         * Be careful to use update you need to pass
         * Array $data.
         * As an associative array where the key
         * should be the column name to update
         * and the value the value to update.
         */
        function queryUpdateRow($table, $data, $column, $search) {
            $vals = array();
            foreach ($data as $key => $value) {
                array_push($vals, "$key = '{$value}'");
            }
            $vals = implode(', ', $vals);
            $sql = "UPDATE {$table} SET {$vals} WHERE {$column}='{$search}';";
            $result = $this->queryAlter($sql);
            $this->result = $result;
        }

        function queryGetAll($table) {
            $sql = "SELECT * FROM {$table};";
            $result = $this->queryGet($sql);
            $result = ($result) ? $result : false;
            $this->result = $result;
        }

        function queryGetColumn($table, $column) {
            $sql = "SELECT {$column} FROM {$table};";
            $result = $this->queryGet($sql);
            $result = ($result) ? $result : false;
            $this->result = $result;
        }

        function queryGetRow($table, $column, $search) {
            $sql = "SELECT * FROM {$table} where {$column} = '{$search}';";
            $result = $this->queryGet($sql);
            $result = ($result) ? $result[0] : false;
            $this->result = $result;
        }

        function createTable($sql) {
            $result = $this->queryAlter($sql);
            $this->result = $result;
        }
        
    }

?>