<?php
session_start();
include_once '../admin/configuraciones/funcionesDB.php';
include_once '../admin/configuraciones/funciones.php';

if (isset($_POST)) {
    // var_dump($_POST);
    // echo "<br/>";
    // var_dump($_SESSION);
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
        realizarSql($conexion, $sql, $datos);
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
        realizarSql($conexion, $sql, $datos);
        $sql = "SELECT count(*) FROM usuario_batalla WHERE accion='denunciar' AND id_batalla='{$_SESSION[SESSION_CURRENT_BATTLE]}'";
        $denuncias = $conexion->query($sql)->fetch(PDO::FETCH_NUM)[0];

        if ($denuncias >= 100) { // CAMBIAR NUMERO
            // Se calculan las denuncias totales que tiene un usuario (puntos de troll)
            $id_usuarioCreador = select(["id_usuario"], "usuario_batalla", ["id_batalla", $_SESSION[SESSION_CURRENT_BATTLE]])[0][0];/*REVISAR*/
            $sql = "SELECT count(*) 
                FROM `usuario_batalla` 
                WHERE accion = 'denunciar'
                    AND id_batalla IN (
                        SELECT id_batalla
                        FROM `usuario_batalla` 
                        WHERE accion = 'crear'
                            AND id_usuario = {$id_usuarioCreador}
                        )";

            $sql = "DELETE FROM `usuario` WHERE id_batalla=?";
            realizarSql($conexion, $sql, [$_SESSION[SESSION_CURRENT_BATTLE]]);
        }
        quitarDatosBatalla();
        //Se tienen que mantener los credenciales de denuncia??
        //Si no como se cuentan puntos de troll??
        //GESTIONAR ELEMENTO_USUARIO TAMBIÉN
        //Comprobar si es la única vez que se usan esos elementos y en ese caso borrarlos
        /*
        No se borran batallas, se mantienen pero no se dejan ver si tienen muchas denuncias
        */
    } else if (isset($_POST["elementoVotado"])) {
        //VIGILAR: ESTA FUNCION PUEDE NO EXISTIR AL SUBIRLO (HABRÍA QUE CREARLA) https://www.php.net/manual/en/function.str-ends-with.php
        if (str_ends_with(htmlspecialchars($_SERVER["HTTP_REFERER"]), "/crearBatalla.php")) {
            $_SESSION[SESSION_BATTLE_ELEM_1] = $_POST["id1"];
            if ($_SESSION[SESSION_BATTLE_ELEM_1] == -1) { // El elemento1 ha sido creado
                $nombre1 = htmlspecialchars($_POST["nombre1"]);
                $img1 = htmlspecialchars($_POST["img1"]);
                $_SESSION[SESSION_BATTLE_ELEM_1] = insertar("elemento", ["", $nombre1, $img1, 0]);
                insertar("usuario_elemento", ["", $_SESSION[SESSION_ID], $_SESSION[SESSION_BATTLE_ELEM_1], "crear", getMomentoActual()]);
            }
            $_SESSION[SESSION_BATTLE_ELEM_2] = $_POST["id2"];
            if ($_SESSION[SESSION_BATTLE_ELEM_2] == -1) { // El elemento2 ha sido creado
                $nombre2 = htmlspecialchars($_POST["nombre2"]);
                $img2 = htmlspecialchars($_POST["img2"]);
                $_SESSION[SESSION_BATTLE_ELEM_2] = insertar("elemento", ["", $nombre2, $img2, 0]);
                insertar("usuario_elemento", ["", $_SESSION[SESSION_ID], $_SESSION[SESSION_BATTLE_ELEM_2], "crear", getMomentoActual()]);
            }
            $_SESSION[SESSION_CURRENT_BATTLE] = insertar("batalla_elemento", ["", $_SESSION[SESSION_BATTLE_ELEM_1], $_SESSION[SESSION_BATTLE_ELEM_2]]);
            $elementoVotado = $_SESSION[SESSION_BATTLE_ELEM_1];
            if ($_POST["elementoVotado"] == 2) {
                $elementoVotado = $_SESSION[SESSION_BATTLE_ELEM_2];
            }
            $_POST["elementoVotado"] = $elementoVotado;
            insertar("usuario_batalla", ["", $_SESSION[SESSION_ID], $_SESSION[SESSION_CURRENT_BATTLE], "crear", getMomentoActual()]);
        }
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
        realizarSql($conexion, $sql, $datos);
    }
}

header("Location: ../index.php");
