<?php
class Database {
    private static $host = "localhost";
    private static $dbname = "agenda_barbearia";
    private static $username = "root";
    private static $password = "";
    private static $conn;

    public static function connect() {
        if (!self::$conn) {
            self::$conn = new PDO("mysql:host=".self::$host.";dbname=".self::$dbname, self::$username, self::$password);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
}