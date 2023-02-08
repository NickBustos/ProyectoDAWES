<?php
include 'config.php';
include 'BD.php';
include 'Elemento.php';
include 'Batalla.php';
include 'Usuario.php';

//------------------------------------- FECHAS --------------------------------------
/**
 * Cada operacion que requiera saber el dateTime llamamos a esta funcion
 * Nos devuelve un string con formato: Año-mes-dia ; Hora:minutos:segundos:milisegundos.
 */
function getMomentoActual()
{
    $momento = new DateTimeImmutable();
    return $momento->format("Y-m-d H:i:s.u");
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

//------------------------------------- FILES --------------------------------------
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

//------------------------------- IDIOMA / TEMA ---------------------------------

/**
 * 1º Si tenemos guardado el ID, los busca en la base de datos.
 * 2º En caso de que no haya iniciado sesion creamos la cookie.
 * 3º Nos devuelve el path, para directamente poner include getIdioma().
 */
function getIdioma($usuario)
{
    $idioma = LANG_SPANISH;
    if ($usuario != null) {
        $idioma = $usuario->idioma;
    } else if (!isset($_COOKIE[LANG])) {
        setcookie(LANG, LANG_SPANISH, time() + 60 * 60, '/');
    } else if ($_COOKIE[LANG] == LANG_ENGLISH) {
        $idioma = LANG_ENGLISH;
    }
    $pathIdioma = "admin/idiomas/" . $idioma . "-idioma.php";
    return $pathIdioma;
}

/**
 * Funcion que devuelve el idioma contrario al introducido
 * Ingles => español y viceversa.
 */
function getIdiomaContrario($idioma)
{
    $nuevoIdioma = LANG_SPANISH;
    if ($idioma == LANG_SPANISH) {
        $nuevoIdioma = LANG_ENGLISH;
    }
    return $nuevoIdioma;
}

/**
 * Funcion que devuelve el tema contrario al introducido
 * Light => dark y viceversa.
 */
function getTemaContrario($tema)
{
    $nuevoTema = TEMA_LIGHT;
    if ($tema == TEMA_LIGHT) {
        $nuevoTema = TEMA_DARK;
    }
    return $nuevoTema;
}

/**
 * Sistema gestor de errores segun el que no se muestran errores
 */
function miGestorDeErrores($nivel, $mensaje)
{
    switch ($nivel) {
        default:
    }
}
/**
 * Establecer sistema de gestores propio
 */
function set_error_manager($gestorErrores = "miGestorDeErrores")
{
    set_error_handler($gestorErrores);
}
/**
 * Volver a gestor de errores de php
 */
function default_error_manager()
{
    restore_error_handler(); // le paso el control de errores a PHP
}

/**
 * Verifica si un string se encuentra al inicio de una cadena.
 * Esta funcion se realiza porque aunque existe una en la versión web no funciona.
 */
function startsWith($cadena, $string) {
    return substr_compare($cadena, $string, 0, strlen($string)) === 0;
}
