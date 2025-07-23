<?php
class NotFoundException extends Exception {}

class RegistroModel {
    private PDO $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function registrarUsuario($data): bool {
        $sql = "INSERT INTO usuarios (nombre_completo, correo, documento_tipo, provincia, id1, id2, id3, usuario, password) VALUES (:nombre_completo, :correo, :documento_tipo, :provincia, :id1, :id2, :id3, :usuario, :password)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre_completo' => $data['nombre_completo'],
            ':correo' => $data['correo'],
            ':documento_tipo' => $data['documento_tipo'],
            ':provincia' => $data['provincia'],
            ':id1' => $data['id1'],
            ':id2' => $data['id2'],
            ':id3' => $data['id3'],
            ':usuario' => $data['usuario'],
            ':password' => $data['password'],
        ]);
    }

    public function usuarioOCorreoExiste($usuario, $correo): bool {
        $sql = "SELECT id FROM usuarios WHERE usuario = :usuario OR correo = :correo";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':usuario' => $usuario, ':correo' => $correo]);
        return $stmt->fetch() !== false;
    }
}
