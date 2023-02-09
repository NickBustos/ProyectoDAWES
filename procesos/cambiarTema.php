<?php
session_start();
include_once '../admin/configuraciones/funciones.php';

$tema=TEMA_LIGHT;
if(isset($_SESSION[SESSION_ID])){
    $sql = "SELECT modovis FROM usuario WHERE id=?";
    $resultado = BD::realizarSql(BD::crearConexion(), $sql, [$_SESSION[SESSION_ID]])[0][0];
    $tema = getTemaContrario($resultado);
    BD::update("usuario", ["modovis"], [$tema], "id", $_SESSION[SESSION_ID]);
}else {
    //No ha iniciado sesión
    if(isset($_SESSION[TEMA])){
        $tema = $_SESSION[TEMA];
    $tema = getTemaContrario($tema);
    }
    $_SESSION[TEMA] = $tema;
}
header('Location: ' . $_SERVER["HTTP_REFERER"]);
?>