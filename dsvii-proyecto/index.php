<?php
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['is_admin']) {
        header('Location: /views/AdminView.php');
    } else {
        header('Location: /views/UserView.php');
    }
    exit;
}

header('Location: /views/LoginView.php');
exit;
