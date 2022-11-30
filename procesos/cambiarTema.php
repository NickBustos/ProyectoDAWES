<?php
session_start();
include_once '../admin/configuraciones/funcionesDB.php';
include_once '../admin/configuraciones/funciones.php';

function getTemaContrario($tema){
    $nuevoTema = TEMA_LIGHT;
    if ($tema == TEMA_LIGHT) {
        $nuevoTema = TEMA_DARK;
    }
    return $nuevoTema;
}

$tema="TEMA_LIGHT";
if(isset($_SESSION[SESSION_ID])){
    //Inició sesion
    $conexion=new PDO(DSN, USER, PASSWORD);
    $sql = "SELECT modovis FROM usuario WHERE ID='{$_SESSION[SESSION_ID]}'";
    $resultado = $conexion->query($sql);
    $resultado->bindColumn(1, $tema);
    $resultado->fetch();
    $tema = getTemaContrario($tema);
    $sql = "UPDATE usuario SET modovis='{$tema}' WHERE ID='{$_SESSION[SESSION_ID]}'";
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