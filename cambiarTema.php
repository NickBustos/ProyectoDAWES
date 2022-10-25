<?php
session_start();
if ($_SESSION['id']['tema'] == 'claro') {
    $_SESSION['id']['tema'] = 'noche';
} else {
    $_SESSION['id']['tema'] = 'claro';
}
header('Location: ' . $_SERVER["HTTP_REFERER"]);
?>