<?php
require 'vendor/autoload.php';

use core\Database;

try {
    $db = Database::getInstance();
    $db->query("SELECT 1");
    echo "Conexão OK!";
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
