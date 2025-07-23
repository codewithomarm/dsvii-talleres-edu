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
require_once __DIR__ . '/controllers/RegistroController.php';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new RegistroController();
    $result = $controller->registrarUsuario(
        $_POST['nombre_completo'] ?? '',
        $_POST['correo'] ?? '',
        $_POST['documento_tipo'] ?? '',
        $_POST['provincia'] ?? '',
        $_POST['id1'] ?? '',
        $_POST['id2'] ?? '',
        $_POST['id3'] ?? '',
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
    <title>Registro - Empresa</title>
    <?php include 'styles.php'; ?>
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div style="height: 40px;"></div>
    
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card p-4 shadow" style="max-width: 500px; width: 100%;">
            <h3 class="mb-4 text-center">Formulario de Registro</h3>
            <?php if ($mensaje): ?>
                <div class="alert alert-info text-center"> <?= htmlspecialchars($mensaje) ?> </div>
            <?php endif; ?>
            <form method="POST" action="registro.php">
                <div class="mb-3">
                    <label for="nombre_completo" class="form-label">Nombre Completo</label>
                    <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" required>
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Documento de Identidad Personal</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="documento_tipo" id="nacional" value="Nacional" required>
                        <label class="form-check-label" for="nacional">Nacional</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="documento_tipo" id="pe" value="P.E.">
                        <label class="form-check-label" for="pe">P.E.</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="documento_tipo" id="pi" value="P.I.">
                        <label class="form-check-label" for="pi">P.I.</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="documento_tipo" id="naturalizado" value="Naturalizado">
                        <label class="form-check-label" for="naturalizado">Naturalizado</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="documento_tipo" id="extranjero" value="Extranjero">
                        <label class="form-check-label" for="extranjero">Extranjero</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="provincia" class="form-label">Provincia</label>
                    <select class="form-select" id="provincia" name="provincia" required>
                        <option value="">Seleccione una provincia</option>
                        <option value="Bocas del Toro">Bocas del Toro</option>
                        <option value="Coclé">Coclé</option>
                        <option value="Colón">Colón</option>
                        <option value="Chiriquí">Chiriquí</option>
                        <option value="Darién">Darién</option>
                        <option value="Herrera">Herrera</option>
                        <option value="Los Santos">Los Santos</option>
                        <option value="Panamá">Panamá</option>
                        <option value="Panamá Oeste">Panamá Oeste</option>
                        <option value="Veraguas">Veraguas</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Número de Identidad</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="text" class="form-control text-center" name="id1" maxlength="2" pattern="\d{2}" style="max-width: 50px;" required>
                        <span>-</span>
                        <input type="text" class="form-control text-center" name="id2" maxlength="5" pattern="\d{5}" style="max-width: 90px;" required>
                        <span>-</span>
                        <input type="text" class="form-control text-center" name="id3" maxlength="5" pattern="\d{5}" style="max-width: 90px;" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="usuario" class="form-label">Nombre de Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Registrar</button>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action="registro.php"]');
        if(form) {
            form.addEventListener('submit', function(e) {
                let valid = true;
                
                if(form.nombre_completo.value.trim() === '') valid = false;
               
                const email = form.correo.value.trim();
                if(!/^\S+@\S+\.\S+$/.test(email)) valid = false;
              
                if(form.usuario.value.trim() === '') valid = false;
                
                if(form.password.value.length < 6) valid = false;
               
                if(!/^\d{2}$/.test(form.id1.value) || !/^\d{5}$/.test(form.id2.value) || !/^\d{5}$/.test(form.id3.value)) valid = false;
                if(!valid) {
                    alert('Por favor, complete correctamente todos los campos.');
                    e.preventDefault();
                }
            });
        }
    });
    </script>
</body>
</html>
