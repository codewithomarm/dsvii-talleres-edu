<?php
class UserController {
    private UserModel $model;

    public function __construct(UserModel $model) {
        $this->model = $model;
    }

    public function register(array $data): void {
        try {
            // Validar campos requeridos básicos (puedes agregar más validaciones)
            if (empty($data['username']) || empty($data['email']) || empty($data['password'])) {
                throw new InvalidArgumentException("Username, email and password are required.");
            }

            // Verificar si el usuario ya existe
            if ($this->model->userExists($data['username'])) {
                throw new Exception("Username already taken.");
            }

            // Hashear contraseña antes de guardar
            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);

            // Llamar al método del modelo para registrar usuario
            $success = $this->model->registerUser($data);

            if (!$success) {
                throw new Exception("Failed to register user.");
            }

            // Registro exitoso
            http_response_code(201);
            echo json_encode(['status' => 'success', 'message' => 'User registered successfully.']);

        } catch (InvalidArgumentException $e) {
            $this->sendErrorResponse(400, $e->getMessage());
        } catch (Exception $e) {
            $this->sendErrorResponse(500, $e->getMessage());
        }
    }

    public function login(string $username, string $password): void {
        try {
            if (empty($username) || empty($password)) {
                throw new InvalidArgumentException("Username and password are required.");
            }

            $user = $this->model->getUserByUsername($username);
            if (!$user) {
                throw new Exception("Invalid credentials.");
            }

            if (!password_verify($password, $user['password_hash'])) {
                throw new Exception("Invalid credentials.");
            }

            // Aquí crear sesión o token según la lógica de la aplicación
            // Ejemplo simple:
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];

            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Login successful.']);

        } catch (InvalidArgumentException $e) {
            $this->sendErrorResponse(400, $e->getMessage());
        } catch (Exception $e) {
            $this->sendErrorResponse(401, $e->getMessage());
        }
    }

    private function sendErrorResponse(int $statusCode, string $message): void {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => $message,
        ]);
        exit;
    }
}
