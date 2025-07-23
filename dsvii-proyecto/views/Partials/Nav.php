<?php session_start(); ?>

<nav class="navbar">
    <div class="nav-links">
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if (!empty($_SESSION['is_admin'])): ?>
                <a href="/../dsvii-talleres-edu/dsvii-proyecto/views/AdminView.php">Admin Panel</a>
                <a href="/../dsvii-talleres-edu/dsvii-proyecto/views/CreateView.php">Create Workshop</a>
                <a href="/../dsvii-talleres-edu/dsvii-proyecto/views/ReportView.php">Reports</a>
            <?php else: ?>
                <a href="/../dsvii-talleres-edu/dsvii-proyecto/views/UserView.php">My Account</a>
                <a href="/../dsvii-talleres-edu/dsvii-proyecto/views/TalleresUsuariosView.php">Workshops</a>
            <?php endif; ?>
            <a href="/dsvii-proyecto/handlers/LogoutHandler.php">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
        <?php else: ?>
            <a href="/../dsvii-talleres-edu/dsvii-proyecto/views/LoginView.php">Login</a>
            <a href="/../dsvii-talleres-edu/dsvii-proyecto/views/RegisterView.php">Register</a>
        <?php endif; ?>
    </div>
</nav>
