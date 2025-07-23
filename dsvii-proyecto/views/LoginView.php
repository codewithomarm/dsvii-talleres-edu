<?php require_once __DIR__ . '/Partials/Top.php'; ?>

<main class="main-container">
    <form class="card" method="POST" action="LoginHandler.php">
        <h2 class="text-center">Inicio de Sesión</h2>

        <?php if (!empty($_GET['error'])): ?>
            <div class="error-message">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($mensaje)): ?>
            <div class="alert-info">
                <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php endif; ?>

        <label for="username">Nombre de usuario</label>
        <input type="text" id="username" name="usuario" required autocomplete="username">

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required autocomplete="current-password">

        <button type="submit">Iniciar Sesión</button>

        <div class="small-text text-center mt-3">
            ¿No tienes cuenta? <a href="register.php">Regístrate</a>
        </div>
    </form>
</main>

<script src="/public/js/login.js"></script>

<?php require_once __DIR__ . '/Partials/Bottom.php'; ?>
