<?php
session_start();
include_once '../admin/configuraciones/funcionesDB.php';
include_once '../admin/configuraciones/funciones.php';

function quitarDatosBatalla(){
    unset($_SESSION[SESSION_CURRENT_BATTLE]);
    unset($_SESSION[SESSION_BATTLE_ELEM_1]);
    unset($_SESSION[SESSION_BATTLE_ELEM_2]);
    unset($_SESSION[SESSION_BATTLE_VOTED]);
}

if (isset($_POST)) {
    var_dump($_POST);
    echo "<br/>";
    var_dump($_SESSION);
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "";
    $datos = [];
    $momento = getMomentoActual();
    if (isset($_POST["siguiente"])) {
        quitarDatosBatalla();
        //borrar datos sesion sobre batalla (unset??)
    } else if (isset($_POST["ignorar"])) {
        $sql = "INSERT INTO usuario_batalla VALUES (
            '', :id_u, :id_b, 'ignorar', :mom
        )";
        $datos = [
            "id_u" => $_SESSION[SESSION_ID],
            "id_b" => $_SESSION[SESSION_CURRENT_BATTLE],
            "mom" => $momento
        ];
        quitarDatosBatalla();
        //borrar datos sesion sobre batalla
    } else if (isset($_POST["denunciar"])) {
        $sql = "INSERT INTO usuario_batalla VALUES (
            '', :id_u, :id_b, 'denunciar', :mom
        )";
        $datos = [
            "id_u" => $_SESSION[SESSION_ID],
            "id_b" => $_SESSION[SESSION_CURRENT_BATTLE],
            "mom" => $momento
        ];
        quitarDatosBatalla();
        //Comprobar nº de denuncias
        //borrar datos sesion sobre batalla
    } else if (isset($_POST["elementoVotado"])) {
        $sql = "INSERT INTO voto VALUES (
            :id_u, :id_b, :id_e, :mom
        )";
        $datos = [
            "id_u" => $_SESSION[SESSION_ID],
            "id_b" => $_SESSION[SESSION_CURRENT_BATTLE],
            "id_e" => $_POST["elementoVotado"],
            "mom" => $momento
        ];
        $_SESSION[SESSION_BATTLE_VOTED]=true;
        //mostrar resultados al recargar???
    }

    if ($sql !== "") {
        $preparedSttm = $conexion->prepare($sql);
        $preparedSttm->execute($datos);
    }
}

// header()
