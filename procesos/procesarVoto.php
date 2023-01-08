<?php
session_start();
include_once '../admin/configuraciones/funciones.php';
// Aquí entras desde votar o crear batalla
if (isset($_POST)) {
    $conexion = new PDO(DSN, USER, PASSWORD);
    $sql = "";
    $datos = [];
    $momento = getMomentoActual();
    $destino = "../index.php";

    // -------------------------------------------------------- SIGUIENTE --------------------------------------------------------

    if (isset($_POST["siguiente"])) {
        // Te quita de la sesión los datos de la batalla para que te muestre una nueva
        quitarDatosBatalla();

        // --------------------------------------------------------- IGNORAR ---------------------------------------------------------

    } else if (isset($_POST["ignorar"])) {
        // Insert de que ha ignorado batalla
        // Te quita de la sesión los datos de la batalla para que te muestre una nueva
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
        // Insert de que ha denunciado batalla
        // Te quita de la sesión los datos de la batalla para que te muestre una nueva
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
                $id_usuarioCreador = select(["id_usuario"], "usuario_batalla", ["id_batalla", $_SESSION[SESSION_CURRENT_BATTLE]])[0][0];
                $puntosTroll = select(["num_batallas_denunciadas"], "usuario", ["id", $id_usuarioCreador])[0][0];
                $puntosTroll++;
                actualizarUsuario("puntos_troll", $puntosTroll, $id_usuarioCreador);
            }

            quitarDatosBatalla();
        } catch (PDOException $e) {
        } catch (Exception $e) {
        }
        // --------------------------------------------------------- VOTAR ---------------------------------------------------------
    } else if (isset($_POST["elementoVotado"])) {
        // Si hay elemento votado es que ha votado
        // Puede venir de crear batalla o del index
        // Si viene de crear se crea la batalla y se inserta el voto
        // Si viene de index solamente se inserta el voto
        try {
            //VIGILAR: ESTA FUNCION PUEDE NO EXISTIR AL SUBIRLO (HABRÍA QUE CREARLA) https://www.php.net/manual/en/function.str-ends-with.php
            $origen = htmlspecialchars(strtolower($_SERVER["HTTP_REFERER"]));
            $referer = explode("/", strtolower($_SERVER["HTTP_REFERER"]));
            // Si la url transformada en minúscula empieza con crear.php viene de alli
            if (str_starts_with($referer[count($referer) - 1], "crear.php")) {
                // Para que se lleve a cabo procesamiento de la misma manera se guarda datos de elemento creados en elementos de batalla
                $_SESSION[SESSION_BATTLE_ELEM_1] = $_SESSION[SESSION_CREAR_ELEM_1];
                $_SESSION[SESSION_BATTLE_ELEM_2] = $_SESSION[SESSION_CREAR_ELEM_2];

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
            // Para saber si has votado o no (en este caso sí)
            $_SESSION[SESSION_BATTLE_VOTED] = true;
            realizarSql($conexion, $sql, $datos);

            $votos = selectFromUsuario(["num_batallas_votadas"])[0];
            $votos++;
            actualizarUsuario("num_batallas_votadas", $votos, $_SESSION[SESSION_ID]);
        } catch (PDOException $e) {
        } catch (Exception $e) {
        }
        // ---------------------------------------------------- RETURN DE VOTAR ----------------------------------------------------

    } else if (isset($_POST["reiniciar"])) {
        // Vueleve al inicio de creación
        $destino = "../crear.php";
        quitarDatosBatalla();

        // ----------------------------------------------------- BORRAR BATALLA -----------------------------------------------------

    } else if (isset($_POST["deleteBattle"])) {
        // Insert de batalla eleminada del administrador
        // Quita datos de batalla para enseñar otra batalla
        insertar("usuario_batalla", ["", $_SESSION[SESSION_ID], $_SESSION[SESSION_CURRENT_BATTLE], "eliminar", getMomentoActual()]);
        quitarDatosBatalla();
    }
}
header("Location: {$destino}");
