<?php
// Conexión básica a la base de datos (comentado para pruebas de diseño)
/*
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tu_base_de_datos";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
*/
require_once __DIR__ . '/controllers/LoginController.php';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new LoginController();
    $result = $controller->validarLogin(
        $_POST['usuario'] ?? '',
        $_POST['password'] ?? ''
    );
    $mensaje = $result['message'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Empresa</title>
    <?php include 'styles.php'; ?>
</head>
<body>
    <?php include 'navbar.php'; ?>
   
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
            <h3 class="mb-4 text-center">Iniciar Sesión</h3>
            <?php if ($mensaje): ?>
                <div class="alert alert-info text-center"> <?= htmlspecialchars($mensaje) ?> </div>
            <?php endif; ?>
            <form method="POST" action="Login.php">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Nombre de usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
            </form>
            <div class="mt-3 text-center">
                <span>Aún no se ha registrado? </span>
                <a href="registro.php">Regístrate</a>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
   
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action="Login.php"]');
        if(form) {
            form.addEventListener('submit', function(e) {
                let valid = true;
                if(form.usuario.value.trim() === '' || form.password.value.trim() === '') valid = false;
                if(!valid) {
                    alert('Por favor, complete usuario y contraseña.');
                    e.preventDefault();
                }
            });
        }
    });
    </script>
</body>
</html>