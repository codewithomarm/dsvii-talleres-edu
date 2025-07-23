<?php
class CRUDModel {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Crear taller
    public function createTaller(array $data): bool {
        $stmt = $this->pdo->prepare("CALL sp_create_taller(?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['titulo'],
            $data['descripcion'],
            $data['cupo_maximo'],
            $data['fecha_inicio'],
            $data['hora_inicio'],
            $data['fecha_fin'],
            $data['hora_fin']
        ]);
    }

    // Actualizar taller
    public function updateTaller(int $id, array $data): bool {
        $stmt = $this->pdo->prepare("CALL sp_update_taller(?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $id,
            $data['titulo'],
            $data['descripcion'],
            $data['cupo_maximo'],
            $data['fecha_inicio'],
            $data['hora_inicio'],
            $data['fecha_fin'],
            $data['hora_fin']
        ]);
    }

    // Eliminar taller
    public function deleteTaller(int $id): bool {
        $stmt = $this->pdo->prepare("CALL sp_delete_taller(?)");
        return $stmt->execute([$id]);
    }

    // Eliminar usuario
    public function deleteUsuario(int $id): bool {
        $stmt = $this->pdo->prepare("CALL sp_delete_usuario(?)");
        return $stmt->execute([$id]);
    }
}
