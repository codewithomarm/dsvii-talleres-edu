<?php 
$extraStyles = '<link rel="stylesheet" href="/../dsvii-talleres-edu/dsvii-proyecto/public/css/LoginView.css">';
require_once __DIR__ . '/Partials/Top.php';
?>

<main>
    <form class="card" method="POST" action="./LoginHandler.php">
        <h2>Inicio de Sesión</h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <label for="username">Nombre de usuario</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Iniciar Sesión</button>

        <div class="small-text text-center mt-3">
            ¿No tienes cuenta? <a href="RegisterView.php">Regístrate</a>
        </div>
    </form>

    <script src="/../dsvii-talleres-edu/dsvii-proyecto/public/js/login.js"></script>
</main>


<?php include '../views/Partials/Bottom.php'; ?>
