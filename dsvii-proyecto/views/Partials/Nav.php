<?php session_start(); ?>
<nav>
    <a href="index.php">Inicio</a>
    <a href="crear_taller.php">Crear Taller</a>

    <?php if (isset($_SESSION['username'])): ?>
        <a href="LogoutHandler.php">Cerrar sesión (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
    <?php else: ?>
        <a href="LoginView.php">Iniciar Sesión</a>
    <?php endif; ?>
</nav>
