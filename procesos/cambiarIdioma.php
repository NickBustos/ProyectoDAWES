<?php
session_start();
include_once '../admin/configuraciones/funcionesDB.php';
include_once '../admin/configuraciones/funciones.php';

$idioma = LANG_SPANISH;
if (isset($_SESSION[SESSION_ID])) {
    //Inició sesion
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "SELECT idioma FROM usuario WHERE ID='{$_SESSION[SESSION_ID]}'";
    $resultado = $conexion->query($sql);
    $resultado->bindColumn(1, $idioma);
    $resultado->fetch();
    $idioma = getIdiomaContrario($idioma);
    $sql = "UPDATE usuario SET idioma='{$idioma}' WHERE ID='{$_SESSION[SESSION_ID]}'";
    $resultado = $conexion->exec($sql);
} else{
    //No inicio sesion
    if (isset($_COOKIE[LANG])) {
        $idioma = $_COOKIE[LANG];
        $idioma = getIdiomaContrario($idioma);
    }
    setCookie(LANG, $idioma, time() + 60*60, '/');
}
header('Location: ' . $_SERVER["HTTP_REFERER"]);
exit();
