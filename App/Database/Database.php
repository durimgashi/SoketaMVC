<?php

namespace App\Database;


use PDO;
use PDOException;

class Database {
    public static $table;
    public static string $primary_key = 'id';
    public static int $active = 1;
    public static int $not_active = 0;

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

    public static function query($query, $fetchStyle = PDO::FETCH_ASSOC) {
        try {
            $conn = static::connect();
            $stmt = $conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll($fetchStyle);
        } catch (\Exception $e) {
            die("Exception : " . $e->getMessage());
        }
    }

    public static function all($fetchStyle = PDO::FETCH_ASSOC) {
        try {
            $conn = static::connect();
            $stmt = $conn->prepare("SELECT * FROM ".static::$table);
            $stmt->execute();
            return $stmt->fetchAll($fetchStyle);
        } catch (\Exception $e) {
            die("Exception : " . $e->getMessage());
        }
    }

    public static function find($id, $fetchStyle = PDO::FETCH_ASSOC) {
        try {
            $conn = static::connect();
            $stmt = $conn->prepare("SELECT * FROM " . static::$table . " WHERE " . self::$primary_key . " = " . $id);
            $stmt->execute();
            return $stmt->fetchAll($fetchStyle);
        } catch (\Exception $e) {
            die("Exception : " . $e->getMessage());
        }
    }
}