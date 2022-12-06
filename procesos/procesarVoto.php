<?php
session_start();
include_once '../admin/configuraciones/funcionesDB.php';
include_once '../admin/configuraciones/funciones.php';

function quitarDatosBatalla()
{
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
    } else if (isset($_POST["denunciar"])) {
        $sql = "INSERT INTO usuario_batalla VALUES (
            '', :id_u, :id_b, 'denunciar', :mom
        )";
        $datos = [
            "id_u" => $_SESSION[SESSION_ID],
            "id_b" => $_SESSION[SESSION_CURRENT_BATTLE],
            "mom" => $momento
        ];

        $consulta = "SELECT count(*) FROM usuario_batalla WHERE accion='denunciar' AND id_batalla='{$_SESSION[SESSION_CURRENT_BATTLE]}'";
        $denuncias = $conexion->query($consulta)->fetch(PDO::FETCH_NUM)[0]+1; //se suma uno porque se cuenta la tuya (aunque todavía no esté subida)
        echo $denuncias;
        if ($denuncias >= 10) {// CAMBIAR NUMERO
            $consulta = "DELETE FROM `batalla_elemento` WHERE id_batalla=?";
            $conexion->prepare($consulta)->execute([$_SESSION[SESSION_CURRENT_BATTLE]]);
            $sql = ""; //Como ya se ha borrado no hace falta insertar la última denuncia
        }
        quitarDatosBatalla();
        //Se tienen que mantener los credenciales de denuncia??
        //Si no como se cuentan puntos de troll??
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
        $_SESSION[SESSION_BATTLE_VOTED] = true;
    }

    if ($sql !== "") {
        $preparedSttm = $conexion->prepare($sql);
        $preparedSttm->execute($datos);
    }
}

header("Location: {$_SERVER['HTTP_REFERER']}");
