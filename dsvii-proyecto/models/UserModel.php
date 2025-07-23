<?php

class UserModel {
    private PDO $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function registerUser(array $data): bool {
        $sql = "CALL sp_register_user(
            :nombre, :username, :email, :password_hash,
            :category_code, :province_code, :letter_prefix, :tomo, :asiento
        )";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':password_hash' => $data['password_hash'],
            ':category_code' => $data['category_code'],
            ':province_code' => $data['province_code'],
            ':letter_prefix' => $data['letter_prefix'],
            ':tomo' => $data['tomo'],
            ':asiento' => $data['asiento'],
        ]);
    }

    public function getUserByUsername(string $username): ?array {
        $stmt = $this->db->prepare("CALL sp_get_user_by_username(:username)");
        $stmt->execute([':username' => $username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result ?: null;
    }

    public function userExists(string $username): bool {
        $stmt = $this->db->prepare("CALL sp_user_exists(:username)");
        $stmt->execute([':username' => $username]);
        $exists = $stmt->fetchColumn();
        $stmt->closeCursor();
        return $exists !== false;
    }
}
