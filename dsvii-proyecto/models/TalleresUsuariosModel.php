<?php
class NotFoundException extends Exception {}

class TalleresUsuariosModel{
   private PDO $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }
       public function getAllTalleres(): array {
        $stmt = $this->db->query("CALL obtener_todos_los_talleres()");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result ?: [];
    }

}
?>