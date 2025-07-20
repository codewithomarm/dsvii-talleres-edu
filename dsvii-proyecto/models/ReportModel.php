<?php
class NotFoundException extends Exception {}

class ReportModel {
    private PDO $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function getAllUsers(): array {
        $stmt = $this->db->query("CALL obtener_todos_los_usuarios()");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result ?: [];
    }

    public function getUserById(int $userId): array {
        if ($userId <= 0) {
            throw new InvalidArgumentException("Invalid user ID.");
        }
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if (!$result) {
            throw new NotFoundException("User not found.");
        }
        return $result;
    }

    public function getAllWorkshops(): array {
        $stmt = $this->db->query("CALL obtener_todos_los_talleres()");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result ?: [];
    }

    public function getWorkshopById(int $workshopId): array {
        if ($workshopId <= 0) {
            throw new InvalidArgumentException("Invalid workshop ID.");
        }
        $stmt = $this->db->prepare("SELECT * FROM talleres WHERE id = :id");
        $stmt->bindParam(':id', $workshopId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if (!$result) {
            throw new NotFoundException("Workshop not found.");
        }
        return $result;
    }

    public function getUsersWithWorkshops(): array {
        $stmt = $this->db->query("CALL usuarios_con_talleres()");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result ?: [];
    }

    public function getWorkshopsWithUsers(): array {
        $stmt = $this->db->query("CALL talleres_con_usuarios()");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result ?: [];
    }

    public function getWorkshopsByUser(string $username): array {
        if (empty($username)) {
            throw new InvalidArgumentException("Username is required.");
        }
        $stmt = $this->db->prepare("CALL inscripciones_por_usuario(:username)");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result ?: [];
    }

    public function getUsersByWorkshop(string $workshopTitle): array {
        if (empty($workshopTitle)) {
            throw new InvalidArgumentException("Workshop title is required.");
        }
        $stmt = $this->db->prepare("CALL inscripciones_por_taller(:title)");
        $stmt->bindParam(':title', $workshopTitle, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result ?: [];
    }
}
