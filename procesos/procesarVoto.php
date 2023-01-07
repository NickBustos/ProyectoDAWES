<?php
session_start();
include_once '../admin/configuraciones/funciones.php';

if (isset($_POST)) {
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "";
    $datos = [];
    $momento = getMomentoActual();
    $destino = "../index.php";

    // -------------------------------------------------------- SIGUIENTE --------------------------------------------------------

    if (isset($_POST["siguiente"])) {
        quitarDatosBatalla();

        // --------------------------------------------------------- IGNORAR ---------------------------------------------------------

    } else if (isset($_POST["ignorar"])) {
        try {
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

            $batallasIgnoradas = selectFromUsuario(["num_batallas_ignoradas"])[0];
            $batallasIgnoradas++;
            actualizarUsuario("num_batallas_ignoradas", $batallasIgnoradas, $_SESSION[SESSION_ID]);
        } catch (PDOException $e) {
        }


        // -------------------------------------------------------- DENUNCIAR --------------------------------------------------------
    } else if (isset($_POST["denunciar"])) {
        try {
            $sql = "INSERT INTO usuario_batalla VALUES (
            '', :id_u, :id_b, 'denunciar', :mom
            )";
            $datos = [
                "id_u" => $_SESSION[SESSION_ID],
                "id_b" => $_SESSION[SESSION_CURRENT_BATTLE],
                "mom" => $momento
            ];
            realizarSql($conexion, $sql, $datos);

            $denuncias = selectFromUsuario(["num_batallas_denunciadas"])[0];
            $denuncias++;
            actualizarUsuario("num_batallas_denunciadas", $denuncias, $_SESSION[SESSION_ID]);

            $sql = "SELECT count(*) FROM usuario_batalla WHERE accion='denunciar' AND id_batalla='{$_SESSION[SESSION_CURRENT_BATTLE]}'";
            $denuncias = $conexion->query($sql)->fetch(PDO::FETCH_NUM)[0];

            if ($denuncias >= 10) { // CAMBIAR NUMERO
                $id_usuarioCreador = select(["id_usuario"], "usuario_batalla", ["id_batalla", $_SESSION[SESSION_CURRENT_BATTLE]])[0][0];/*REVISAR*/
                $puntosTroll = select(["num_batallas_denunciadas"], "usuario", ["id", $id_usuarioCreador])[0][0];
                $puntosTroll++;
                actualizarUsuario("puntos_troll", $puntosTroll, $id_usuarioCreador);

                // Esto no se si hace falta hacerlo (o se puede) 
                // (es ver si los elementos de batallas elminadas se borrar):
                // $elementos = [$_SESSION[SESSION_BATTLE_ELEM_1], $_SESSION[SESSION_BATTLE_ELEM_2]];
                // $sql = "SELECT COUNT(*) FROM batalla_elemento where id_elemento1=? OR id_elemento2=?";
                // $preparedSttm = $conexion->prepare($sql);
                // foreach ($elemtos as $elemento) {
                //     $datos = [$elemento, $elemento];
                //     $preparedSttm->execute($datos);
                //     $usosElemento = $preparedSttm->fetchAll()[0];
                //     if ($usosElemento - 1 == 0) {
                //         //borrar elemento
                //     }
                // }
            }

            quitarDatosBatalla();
        } catch (PDOException $e) {
        } catch (Exception $e) {
        }
        // --------------------------------------------------------- VOTAR ---------------------------------------------------------
    } else if (isset($_POST["elementoVotado"])) {
        try {
            
            //VIGILAR: ESTA FUNCION PUEDE NO EXISTIR AL SUBIRLO (HABRÍA QUE CREARLA) https://www.php.net/manual/en/function.str-ends-with.php
            $origen = htmlspecialchars(strtolower($_SERVER["HTTP_REFERER"]));
            if (str_ends_with($origen, "/crearbatalla.php")) {

                $_SESSION[SESSION_BATTLE_ELEM_1] = $_POST["id1"];
                if ($_SESSION[SESSION_BATTLE_ELEM_1] == -1) { // El elemento1 ha sido creado
                    $nombre1 = htmlspecialchars($_POST["nombre1"]);
                    $img1 = htmlspecialchars($_POST["img1"]);
                    $_SESSION[SESSION_BATTLE_ELEM_1] = insertar("elemento", ["", $nombre1, $img1, 0]);
                    insertar("usuario_elemento", ["", $_SESSION[SESSION_ID], $_SESSION[SESSION_BATTLE_ELEM_1], "crear", getMomentoActual()]);

                    $elementosCreados = selectFromUsuario(["num_elementos_creados"])[0];
                    $elementosCreados++;
                    actualizarUsuario("num_elementos_creados", $elementosCreados, $_SESSION[SESSION_ID]);
                }

                $_SESSION[SESSION_BATTLE_ELEM_2] = $_POST["id2"];

                if ($_SESSION[SESSION_BATTLE_ELEM_2] == -1) { // El elemento2 ha sido creado
                    $nombre2 = htmlspecialchars($_POST["nombre2"]);
                    $img2 = htmlspecialchars($_POST["img2"]);
                    $_SESSION[SESSION_BATTLE_ELEM_2] = insertar("elemento", ["", $nombre2, $img2, 0]);
                    insertar("usuario_elemento", ["", $_SESSION[SESSION_ID], $_SESSION[SESSION_BATTLE_ELEM_2], "crear", getMomentoActual()]);

                    $elementosCreados = selectFromUsuario(["num_elementos_creados"])[0];
                    $elementosCreados++;
                    actualizarUsuario("num_elementos_creados", $elementosCreados, $_SESSION[SESSION_ID]);
                }
                $_SESSION[SESSION_CURRENT_BATTLE] = insertar("batalla_elemento", ["", $_SESSION[SESSION_BATTLE_ELEM_1], $_SESSION[SESSION_BATTLE_ELEM_2]]);
                $elementoVotado = $_SESSION[SESSION_BATTLE_ELEM_1];
                if ($_POST["elementoVotado"] == 2) {
                    $elementoVotado = $_SESSION[SESSION_BATTLE_ELEM_2];
                }
                $_POST["elementoVotado"] = $elementoVotado;
                insertar("usuario_batalla", ["", $_SESSION[SESSION_ID], $_SESSION[SESSION_CURRENT_BATTLE], "crear", getMomentoActual()]);

                $batallasCreadas = selectFromUsuario(["num_batallas_creadas"])[0];
                $batallasCreadas++;
                actualizarUsuario("num_batallas_creadas", $batallasCreadas, $_SESSION[SESSION_ID]);
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

            $votos = selectFromUsuario(["num_batallas_votadas"])[0];
            $votos++;
            actualizarUsuario("num_batallas_votadas", $votos, $_SESSION[SESSION_ID]);
        } catch (PDOException $e) {
        } catch (Exception $e) {
        }
        // ---------------------------------------------------- RETURN DE VOTAR ----------------------------------------------------

    } else if (isset($_POST["return"])) {
        $destino = "../crearBatalla.php";
        quitarDatosBatalla();

        // ----------------------------------------------------- BORRAR BATALLA -----------------------------------------------------

    } else if (isset($_POST["deleteBattle"])) {
        insertar("usuario_batalla", ["", $_SESSION[SESSION_ID], $_SESSION[SESSION_CURRENT_BATTLE], "eliminar", getMomentoActual()]);
        quitarDatosBatalla();
    }
}
header("Location: {$destino}");
