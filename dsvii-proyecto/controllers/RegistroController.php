<?php

require_once __DIR__ . '/../models/RegistroModel.php';
class RegistroController {
    private PDO $db;
    private RegistroModel $model;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
        $this->model = new RegistroModel($pdo);
    }

    public function registrarUsuario($nombre_completo, $correo, $documento_tipo, $provincia, $id1, $id2, $id3, $usuario, $password) {
        $nombre_completo = trim($nombre_completo);
        $correo = trim($correo);
        $usuario = trim($usuario);
        $password = trim($password);
        $id1 = trim($id1);
        $id2 = trim($id2);
        $id3 = trim($id3);
       
        if ($nombre_completo === '' || $correo === '' || $usuario === '' || $password === '' || $id1 === '' || $id2 === '' || $id3 === '') {
            return ['success' => false, 'message' => 'Todos los campos son obligatorios.'];
        }
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Correo electrónico no válido.'];
        }
        if (!preg_match('/^\d{2}$/', $id1) || !preg_match('/^\d{5}$/', $id2) || !preg_match('/^\d{5}$/', $id3)) {
            return ['success' => false, 'message' => 'Número de identidad no válido.'];
        }
        if (strlen($password) < 6) {
            return ['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres.'];
        }
        
        if ($this->model->usuarioOCorreoExiste($usuario, $correo)) {
            return ['success' => false, 'message' => 'El usuario o correo ya existe.'];
        }
       
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $data = [
            'nombre_completo' => $nombre_completo,
            'correo' => $correo,
            'documento_tipo' => $documento_tipo,
            'provincia' => $provincia,
            'id1' => $id1,
            'id2' => $id2,
            'id3' => $id3,
            'usuario' => $usuario,
            'password' => $password_hash
        ];
        if ($this->model->registrarUsuario($data)) {
            return ['success' => true, 'message' => 'Registro exitoso'];
        } else {
            return ['success' => false, 'message' => 'Error al registrar el usuario.'];
        }
    }
}
