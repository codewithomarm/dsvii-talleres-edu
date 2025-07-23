<?php
session_start();
session_unset();
session_destroy();

// Redirigir a login tras cerrar sesión
header('Location: /LoginView.php');
exit;
