<?php
session_start();
if ($_SESSION['tema'] == 'claro') {
    $_SESSION['tema'] = 'noche';
} else {
    $_SESSION['tema'] = 'claro';
}
header('Location: ' . $_SERVER["HTTP_REFERER"]);
?>