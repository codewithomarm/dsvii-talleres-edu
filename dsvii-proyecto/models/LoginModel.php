<?php

class LoginModel {
    private PDO $db;
    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }
    public function getUsuarioPorNombre($usuario) {
        $sql = "SELECT id, usuario, password FROM usuarios WHERE usuario = :usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':usuario' => $usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
