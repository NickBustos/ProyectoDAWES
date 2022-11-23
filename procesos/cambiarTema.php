<?php
session_start();
include_once 'configDB.php';

define("TEMA", "modovis");
define("TEMA_LIGHT", "light");
define("TEMA_DARK", "dark");

//HACER CONSTANTES DE VALORES
function getTemaContrario($tema){
    $nuevoTema = TEMA_LIGHT;
    if ($tema == TEMA_LIGHT) {
        $nuevoTema = TEMA_DARK;
    }
    return $nuevoTema;
}

$tema="TEMA_LIGHT";
if(isset($_SESSION["idBBDD"])){
    //Inició sesion
    $conexion=new PDO(DSN, USER, PASSWORD);
    $sql = "SELECT modovis FROM usuario WHERE ID='{$_SESSION["idBBDD"]}'";
    $resultado = $conexion->query($sql);
    $resultado->bindColumn(1, $tema);
    $resultado->fetch();
    $tema = getTemaContrario($tema);
    $sql = "UPDATE usuario SET modovis='{$tema}' WHERE ID='{$_SESSION["idBBDD"]}'";
    $resultado = $conexion->exec($sql);
}else {
    //No ha iniciado sesión
    if(isset($_SESSION[TEMA])){
        $tema = $_SESSION[TEMA];
    $tema = getTemaContrario($tema);
    }
    $_SESSION[TEMA] = $tema;
}
header('Location: ' . $_SERVER["HTTP_REFERER"]);
// var_dump($tema);
?>