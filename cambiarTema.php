<?php
/**
 * Captura el valor de $_SESSION("tema").
 * Si es igual a "claro" cambia a "noche"
 * Sino, cambia a "claro".
 * Luego te muestra la página previa.
 */
session_start();
if ($_SESSION['tema'] == 'claro') {
    $_SESSION['tema'] = 'noche';
} else {
    $_SESSION['tema'] = 'claro';
}
header('Location: ' . $_SERVER["HTTP_REFERER"]);
?>