<?php

require_once __DIR__ . '/../models/LoginModel.php';
class LoginController {
    private PDO $db;
    private LoginModel $model;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
        $this->model = new LoginModel($pdo);
    }

    public function validarLogin($usuario, $password) {
        session_start();
        $usuario = trim($usuario);
        $password = trim($password);
        if ($usuario === '' || $password === '') {
            return ['success' => false, 'message' => 'Usuario y contraseña son obligatorios.'];
        }
        $user = $this->model->getUsuarioPorNombre($usuario);
        if (!$user) {
            return ['success' => false, 'message' => 'Usuario o contraseña incorrectos.'];
        }
        if (password_verify($password, $user['password'])) {
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['usuario_id'] = $user['id'];
            header('Location: index.php');
            exit();
        } else {
            return ['success' => false, 'message' => 'Usuario o contraseña incorrectos.'];
        }
    }
}
