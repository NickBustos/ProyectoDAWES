<?php
session_start();
include_once '../admin/configuraciones/funciones.php';
// Aquí entras desde votar o crear batalla
if (isset($_POST)) {
    $usuario = new Usuario($_SESSION[SESSION_ID], $_SESSION[SESSION_USER]);
    
    // $conexion = new PDO(DSN, USER, PASSWORD);
    // $sql = "";
    // $datos = [];
    // $momento = getMomentoActual();
    $destino = "../index.php";

    // -------------------------------------------------------- SIGUIENTE --------------------------------------------------------
    if (isset($_POST["siguiente"])) {
        $batalla = new Batalla($_SESSION[SESSION_CURRENT_BATTLE]);
        $usuario->siguienteBatalla($batalla);
        // --------------------------------------------------------- IGNORAR ---------------------------------------------------------
    } else if (isset($_POST["ignorar"])) {
        // Insert de que ha ignorado batalla
        // Te quita de la sesión los datos de la batalla para que te muestre una nueva
        $batalla = new Batalla($_SESSION[SESSION_CURRENT_BATTLE]);
        $usuario->ignorarBatalla($batalla);
        // -------------------------------------------------------- DENUNCIAR --------------------------------------------------------
    } else if (isset($_POST["denunciar"])) {
        // Insert de que ha denunciado batalla
        // Te quita de la sesión los datos de la batalla para que te muestre una nueva
        $batalla = new Batalla($_SESSION[SESSION_CURRENT_BATTLE]);
        $usuario->denunciarBatalla($batalla);
        // --------------------------------------------------------- VOTAR ---------------------------------------------------------
    } else if (isset($_POST["elementoVotado"])) {
        // Si hay elemento votado es que ha votado
        // Puede venir de crear batalla o del index
        // Si viene de crear se crea la batalla y se inserta el voto
        // Si viene de index solamente se inserta el voto
        $origen = htmlspecialchars(strtolower($_SERVER["HTTP_REFERER"]));
        $referer = explode("/", strtolower($_SERVER["HTTP_REFERER"]));
        // Si la url transformada en minúscula empieza con crear.php viene de alli
        if (startsWith($referer[count($referer) - 1], "crear.php")) {
            // Para que se lleve a cabo procesamiento de la misma manera se guarda datos de elemento creados en elementos de batalla
            $_SESSION[SESSION_CURRENT_BATTLE] = $usuario->crearBatalla($_SESSION[SESSION_CREAR_ELEM_1], $_SESSION[SESSION_CREAR_ELEM_2]);
            $elementoVotado = $_SESSION[SESSION_CREAR_ELEM_1];
            if ($_POST["elementoVotado"] == 2) {
                $elementoVotado = $_SESSION[SESSION_CREAR_ELEM_2];
            }
            $_POST["elementoVotado"] = $elementoVotado;
        }
        $batalla = new Batalla($_SESSION[SESSION_CURRENT_BATTLE]);
        $usuario->votarBatalla($batalla, new Elemento($_POST["elementoVotado"]));
        $usuario->limpiarSesion([SESSION_CURRENT_BATTLE, SESSION_BATTLE_VOTED, SESSION_CREAR_ELEM_1, SESSION_CREAR_ELEM_2]);
        // ---------------------------------------------------- RETURN DE VOTAR ----------------------------------------------------

    } else if (isset($_POST["reiniciar"])) {
        // Vueleve al inicio de creación
        $destino = "../crear.php";
        $usuario->limpiarSesion([SESSION_CREAR_ELEM_1, SESSION_CREAR_ELEM_2]);

        // ----------------------------------------------------- BORRAR BATALLA -----------------------------------------------------

    } else if (isset($_POST["deleteBattle"])) {
        // Insert de batalla eleminada del administrador
        // Quita datos de batalla para enseñar otra batalla
        BD::insertar("usuario_batalla", ["", $_SESSION[SESSION_ID], $_SESSION[SESSION_CURRENT_BATTLE], "eliminar", getMomentoActual()]);
        $usuario->limpiarSesion([SESSION_CURRENT_BATTLE]);
    }
}
header("Location: {$destino}");
