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
        
    }

?>