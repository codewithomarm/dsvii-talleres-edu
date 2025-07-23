<?php session_start(); ?>
<nav>
<?php if (isset($_SESSION['user_id'])): ?>
    <?php if (!empty($_SESSION['is_admin'])): ?>
      <a href=" AdminView.php">Admin Panel</a>
    <a href="crear_taller.php">Create Workshop</a>
    <a href="ReportView.php">Reports</a>
<?php else: ?>
    <a href="UserView.php">My Account</a>
    <a href="TalleresUsuariosView.php">Workshops</a>
<?php endif; ?>

<a href="LogoutHandler.php">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
<?php else: ?>
    <a href="LoginView.php">Login</a>
    <a href="RegisterView.php">Register</a>
<?php endif; ?>
</nav>