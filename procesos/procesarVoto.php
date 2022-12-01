<?php
session_start();
include_once '../admin/configuraciones/funcionesDB.php';
include_once '../admin/configuraciones/funciones.php';

if(isset($_POST)){
    var_dump($_POST);
    echo "<br/>";
    var_dump($_SESSION);
    if(isset($_POST["siguiente"])){
        
        //borrar datos sesion sobre batalla (unset??)
    }else if(isset($_POST["denunciar"])){
        //subir usuario_batalla denuncia
        //Comprobar nº de denuncias
        //borrar datos sesion sobre batalla
    }else if(isset($_POST["elementoVotado"])){
        //subir voto
        //mostrar resultados al recargar???
    }
}

// header()
?>