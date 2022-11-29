<?php
include 'config.php';
include 'configDB.php';

//--------------------------------- OPERACIONES BBDD --------------------------------
/**
 * Coger valor de una línea de registrados.txt
 * usar constantes LYNE_TYPE
 */
function getDato($type, $linea)
{
    $separatedLine = explode(LINE_SEPARATOR, $linea);
    $dato = $separatedLine[$type];
    if ($type === LINE_FILE) {
        $dato = $separatedLine[$type] . ";" . $separatedLine[$type + 1];
    }
    return $dato;
}

/**
 * Averigua si un usuario se encuentra en registrados.txt
 * @return línea completa en la que se encuentra o comillas vacías si no lo encuentra
 * transmitiendo el mensaje de error correspondiente.
 */
function getLineaFrom($user)
{
    $fp = fopen("admin/datos/registrados.txt", "r");
    while (!feof($fp)) {
        $linea = fgets($fp);
        if (strcmp($user, getDato(LINE_USER, $linea)) == 0) {
            break;
        }
        $linea = "";
    }
    fclose($fp);
    return $linea;
}

/**
 * Guardar usuario en registrados.txt
 * @param [user, md5(pass), mail, fecha, file]
 */
function registerUser($userData)
{
    $fp = fopen("admin/datos/registrados.txt", "a");
    fwrite($fp, "\n");
    fwrite($fp, implode(LINE_SEPARATOR, $userData));
    fclose($fp);
}

//---------------------------------- VALIDACIONES -----------------------------------
/**
 * Verifica si han pasado 18 años desde fecha
 */
function validarMayorEdad($fechanacimiento)
{
    list($ano, $mes, $dia) = explode("-", $fechanacimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($dia_diferencia < 0 || $mes_diferencia < 0)
        $ano_diferencia--;
    if ($ano_diferencia >= 18) {
        return true;
    } else {
        return false;
    }
}

//------------------------------------- FILES ---------------------------------------
/**
 * Recoge imagen de un file
 * @param $_FILES["nombreFile"]
 * @return imagen
 */
function getImage($file)
{
    if (empty($file) == false) {
        return "data:" . $file["type"] . ";base64," .
            base64_encode(file_get_contents($file["tmp_name"]));
    }
}

//----------------------------- OPERACIONES CON COOKIES -----------------------------
// function getIdioma($nombrePagina)
// {
//     $pathIdioma = "";
//     if (!isset($_COOKIE["lang"])) {
//         setcookie("lang", "es", time() + 60 * 60);
//         $pathIdioma = "admin/idiomas/es-" . $nombrePagina;
//     } else {
//         $pathIdioma = "admin/idiomas/" . $_COOKIE["lang"] . "-" . $nombrePagina;
//     }
//     return $pathIdioma;
// }

//----------------------------- OPERACIONES CON SESION -----------------------------
/**
 * Introduce datos del usuario en sesion
 */
function iniciarSesion($linea)
{
    $_SESSION[SESSION_USER] = getDato(LINE_USER, $linea);
    $_SESSION[SESSION_PASS] = getDato(LINE_PASS, $linea);
    $_SESSION[SESSION_MAIL] = getDato(LINE_MAIL, $linea);
    $_SESSION[SESSION_DATE] = getDato(LINE_DATE, $linea);
    $_SESSION[SESSION_FILE] = getDato(LINE_FILE, $linea);
}

//----------------------------- Función para registrar los datos en la BD sin el modo Visualización y sin Idioma-----------------------------
$conexion_db = new PDO($DSN,USER,PASSWORD);

function insertarCliente($fechaNac, $image, $email, $rol){

    if(isset($conexion_db)){
        $sql = "INSERT INTO 'USUARIO' ('FechaNacimiento','FotoURL', 'Email', 'Rol' VALUES ('[$fechaNac]','[$image]','[$email]','[$rol]')";
        $pdostmt = $conexion_db->prepare(($sql));
        $pdostmt->execute();

}
}
