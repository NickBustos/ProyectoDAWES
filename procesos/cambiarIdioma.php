<?php
session_start();
include_once 'configDB.php';

define("LANG_ENGLISH", "en");
define("LANG_SPANISH", "es");
define("LANG", "lang");

//HACER CONSTANTES DE VALORES
function getIdiomaContrario($idioma)
{
    $nuevoIdioma = LANG_SPANISH;
    if ($idioma == LANG_SPANISH) {
        $nuevoIdioma = LANG_ENGLISH;
    }
    return $nuevoIdioma;
}

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
    if (isset($_COOKIE["lang"])) {
        $idioma = $_COOKIE["lang"];
        $idioma = getIdiomaContrario($idioma);
    }
    setCookie("lang", $idioma, time() + 60, '/');
}
header('Location: ' . $_SERVER["HTTP_REFERER"]);
exit();
