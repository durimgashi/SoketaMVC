<?php

namespace App\Database;


use PDO;
use PDOException;

class Database
{
    public static $table;
    public static $active = 1;
    public static $not_active = 0;

    protected static function connect() {
        try {
            $conn = new PDO("mysql:host=".HOST.";dbname=". DB_NAME, DB_USERNAME, DB_PASSWORD);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

}