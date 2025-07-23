<?php
<<<<<<< HEAD
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../controllers/UserController.php';
=======

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
>>>>>>> c4ee12db3bc7e1beab5177096928747a7008fa84

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = (new Database())->getConnection();
    $userModel = new UserModel($pdo);
    $userController = new UserController($userModel);

    $data = [
        'full_name' => $_POST['full_name'] ?? '',
        'username' => $_POST['username'] ?? '',
        'email' => $_POST['email'] ?? '',
        'password' => $_POST['password'] ?? '',
        'id_type' => $_POST['id_type'] ?? '',
        'province' => $_POST['province'] ?? '',
        'id_part1' => $_POST['id_part1'] ?? '',
        'id_part2' => $_POST['id_part2'] ?? '',
        'id_part3' => $_POST['id_part3'] ?? '',
    ];

    ob_start();
    $userController->register($data);
    $response = ob_get_clean();
    $result = json_decode($response, true);
    $message = $result['message'] ?? 'There was a problem during registration.';
}

require_once __DIR__ . '/Partials/Top.php';
?>

<main class="container">
  <div class="card">
    <form method="POST" action="">
      <h3 class="text-center">Registration Form</h3>

      <?php if ($message): ?>
        <div class="alert-info"><?= htmlspecialchars($message) ?></div>
      <?php endif; ?>

      <label for="full_name">Full Name</label>
      <input type="text" id="full_name" name="full_name" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>

      <label>ID Type</label>
      <div class="radio-group">
        <?php foreach (["National", "P.E.", "P.I.", "Naturalized", "Foreigner"] as $i => $type): ?>
          <label>
            <input type="radio" name="id_type" value="<?= $type ?>" <?= $i === 0 ? 'required' : '' ?>>
            <?= $type ?>
          </label>
        <?php endforeach; ?>
      </div>

      <label for="province">Province</label>
      <select id="province" name="province" required>
        <option value="">Select a province</option>
        <?php foreach ([
          "Bocas del Toro", "Coclé", "Colón", "Chiriquí", "Darién",
          "Herrera", "Los Santos", "Panamá", "Panamá Oeste", "Veraguas"
        ] as $province): ?>
          <option value="<?= $province ?>"><?= $province ?></option>
        <?php endforeach; ?>
      </select>

      <label>ID Number</label>
      <div style="display: flex; gap: 10px;">
        <input type="text" name="id_part1" maxlength="2" pattern="\d{2}" required style="max-width: 50px;">
        <span>-</span>
        <input type="text" name="id_part2" maxlength="5" pattern="\d{5}" required style="max-width: 90px;">
        <span>-</span>
        <input type="text" name="id_part3" maxlength="5" pattern="\d{5}" required style="max-width: 90px;">
      </div>

      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" minlength="6" required>

      <button type="submit">Register</button>
    </form>
  </div>
</main>

<script src="/../dsvii-talleres-edu/dsvii-proyecto/public/js/register.js"></script>

<?php
include __DIR__ . '/Partials/Bottom.php';
?>
