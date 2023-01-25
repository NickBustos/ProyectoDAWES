<?php
session_start();
include_once '../admin/configuraciones/funciones.php';

$idioma = LANG_SPANISH;
if (isset($_SESSION[SESSION_ID])) {
    $sql = "SELECT idioma FROM usuario WHERE id=?";
    $resultado = BD::realizarSql(BD::crearConexion(), $sql, [$_SESSION[SESSION_ID]])[0][0];
    $idioma = getIdiomaContrario($resultado);
    BD::update("usuario", ["idioma"], [$idioma], "id", $_SESSION[SESSION_ID]);
} else{
    //No inicio sesion
    if (isset($_COOKIE[LANG])) {
        $idioma = $_COOKIE[LANG];
        $idioma = getIdiomaContrario($idioma);
    }
    setCookie(LANG, $idioma, time() + 60*60, '/');
}
header('Location: ' . $_SERVER["HTTP_REFERER"]);
