<?php

/**
 * CLASS: DatabaseHelper
 * a helper object class that provides a shortcut to getting
 * arrays from a database and also updating its values.
 */

class DatabaseHelper {

    private $db_hostname;
    private $db_database;
    private $db_username;
    private $db_password;

    public function __construct($hostname, $database, $username, $password) {
        $this->db_hostname = $hostname;
        $this->db_database = $database;
        $this->db_username = $username;
        $this->db_password = $password;
    }
    /**
     * Queries the database using an SQL query parameter and
     * returns the result as an associative array.
     */
    public function get($sql_query) {
        // Attempt database connection and then execute the query
        try {
            $data_source_hostname = $this->db_hostname;
            $data_source_database = $this->db_database;
            $data_source_username = $this->db_username;
            $data_source_password = $this->db_password;
            $sql_connection = new PDO("mysql:host=$data_source_hostname;dbname=$data_source_database", $data_source_username, $data_source_password);
            $sql_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql_statement = $sql_connection->prepare($sql_query);
            $sql_statement->execute();
            $sql_result_array = $sql_statement->fetchAll(\PDO::FETCH_ASSOC);
            // Return an error message on exception
        } catch (PDOException $exception) {
            echo "Exception: " . $exception->getMessage();
            $sql_connection = null;
        }
        $sql_connection = null;
        return $sql_result_array;
    }

    /**
     * Queries the database but does not return anything.
     * This function is used to make changes to the database.
     */
    public function set($sql_query) {

        try {
            $data_source_hostname = $this->db_hostname;
            $data_source_database = $this->db_database;
            $data_source_username = $this->db_username;
            $data_source_password = $this->db_password;
            $sql_connection = new PDO("mysql:host=$data_source_hostname;dbname=$data_source_database", $data_source_username, $data_source_password);
            $sql_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql_connection->exec($sql_query);
        } catch (PDOException $exception) {
            echo $sql_query . "<br>" . $exception->getMessage();
        }

        $sql_connection = null;
    }

    public function is_this_table_created($table_name) {
        $result_rows = $this->get("SHOW TABLES LIKE '%$table_name%'; ");
        $count = count($result_rows);
        if ($count == 0) {
            return false;
        } else {
            return true;
        }
    }
}
