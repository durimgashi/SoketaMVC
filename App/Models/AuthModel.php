<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class AuthModel extends Database {
    public static $table = 'user';
    function __construct() {
    }

    public static function getUser() {
        $conn = static::connect();
        $stmt = $conn->prepare("SELECT * FROM " . self::$table);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);

        sendData($res);
    }
}