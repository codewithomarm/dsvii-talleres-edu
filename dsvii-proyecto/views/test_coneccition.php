<?php
require_once __DIR__ . '/../core/Database.php';

try {
    $db = new Database();
    $pdo = $db->getConnection();

    $stmt = $pdo->query("SELECT DATABASE() AS db_name");
    $result = $stmt->fetch();

    echo "Conexión exitosa a la base de datos: " . $result['db_name'];
} catch (Exception $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
