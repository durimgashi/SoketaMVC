<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class AuthModel extends Database {
    public static $table = 'user';
    function __construct() {

    }

    public static function rawQuery() {
        send(static::query("SELECT firstName, lastName FROM " . static::$table));
    }

    public static function getAll() {
        send(static::all());
    }

    public static function findUser($id) {
        send(static::find($id));
    }
}