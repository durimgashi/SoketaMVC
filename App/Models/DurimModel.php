<?php

namespace App\Models;
use App\Database\Database;
use PDO;

class DurimModel extends Database {
    public static $table = 'durim';


    public static function test() {
        return [
            "name" => "Durim Gashi"
        ];
    }
}