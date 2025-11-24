<?php
namespace App;

use SQLite3;

class Database
{
    public static function connect()
    {
        $db = new SQLite3(__DIR__ . '/../database.sqlite');

        $db->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL
        )");
        
        return $db;
    }
}

