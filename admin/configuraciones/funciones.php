<?php
include 'config.php';

//----------------------------------- VALIDACIONES -----------------------------------

/**
 * Comprueba si una variable está vacía.
 * Sí, return true, no, false, transmitiendo un mensaje de error.
 */
function vacio($variable, &$errorVariable)
{
    if (empty($variable)) {
        $errorVariable = ERROR_VACIO;
        return true;
    }
    return false;
}

/**
 * Comprueba si una variable está usando el caracter separador (LINE_SEPARATOR).
 * Sí, return true, no, false, transmitiendo un mensaje de error.
 */
function hasCharacterSeparator($variable, &$errorVariable)
{
    if (preg_match(PATTERN_CHARACTER_SEPARATOR, $variable) == true) {
        $errorVariable = ERROR_CHARACTER_SEPARATOR;
        return true;
    }
    return false;
}

/**
 * Comprueba que un string es un nombre válido.
 * Sí, return true, no, false, transmitiendo un mensaje de error.
 */
function validarUser($user, &$errorUser)
{
    if (vacio($user, $errorUser)) {
        return false;
    }
    if (preg_match(PATTERN_USER, $user) == false) {
        $errorUser = ERROR_USER_PATTERN;
        return false;
    }
    if (hasCharacterSeparator($user, $errorUser)) {
        return false;
    }
    return true;
}

/**
 * Confirma que un string ($password) coincide con PATTERN_PASS
 * Sí, return true, no, false y transmite error.
 */
function validarPassword($password, &$errorPassword)
{
    if (
        !preg_match(PATTERN_PASS, $password)
    ) {
        $errorPassword = ERROR_PASS_FORMAT;
        return false;
    }
    return true;
}

/**
 * Confirma que 2 string tienen el formato de contraseña correcto y son iguales.
 * En ese caso return true, sino, false, transmitiendo el error correspondiente.
 */
function validarBothPasswords($password1, $password2, &$errorPassword)
{
    if (vacio($password1, $errorPassword)) {
        return false;
    }
    if (validarPassword($password1, $errorPassword) == false) {
        return false;
    }
    if (vacio($password2, $errorPassword)) {
        return false;
    }
    if ($password1 != $password2) {
        $errorPassword = ERROR_PASS_MATCH;
        return false;
    }
    return true;
}

/**
 * Confirma que un string tiene el formato de un mail.
 * Sí, return true, no, false, transmitiendo el error correspondiente.
 */
function validarMail($mail, &$errorMail)
{
    if (vacio($mail, $errorMail)) {
        return false;
    }
    if (filter_var($mail, FILTER_VALIDATE_EMAIL) == false) {
        $errorMail = ERROR_MAIL;
        return false;
    }
    if (hasCharacterSeparator($mail, $errorMail)) {
        return false;
    }
    return true;
}

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

/**
 * Confirma que un dato es una fecha adecuada para el programa.
 * Lo es, return true, no, false, transmitiendo el error correspondiente.
 */
function validarFechaNac($fechaNac, &$errorFecha)
{
    if (vacio($fechaNac, $errorFecha)) {
        return false;
    }
    if (validarMayorEdad($fechaNac) == false) {
        $errorFecha = ERROR_DATE_YEAR;
        return false;
    }
    return true;
}

/**
 * Confirma que "$_FILES" tiene una imagen "avatar" válida.
 * Sí, return true, no, false, transmitiendo el error correspondiente.
 */
function validarAvatar($files, &$errorFile)
{
    if (
        empty($files) || empty($files["avatar"])
        || empty($files["avatar"]["tmp_name"])
    ) {
        $errorFile = ERROR_VACIO;
        return false;
    }
    if ($files["avatar"]["type"] != "image/png") {
        $errorFile = ERROR_FILE_TYPE;
        return false;
    }
    if ($files['avatar']['size'] > 1000000) { //1 mega
        $errorFile = ERROR_FILE_SIZE;
        return false;
    }
    return true;
}

/**
 * Comprueba que una md5(pass) coincide con la de la línea en
 * la que se encuentra el usuario introducido
 * Sí, return true, no, false, transmitiendo el error correspondiente.
 */
function validarLoginPass($pass, &$errorPass, $linea)
{
    if (vacio($pass, $errorPass)) {
        return false;
    }
    if ($pass != getDato(LINE_PASS, $linea)) {
        $errorPass = ERROR_LOGIN_PASS;
        return false;
    }
    return true;
}



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
function getLineaFrom($user, &$errorUser)
{
    if (vacio($user, $errorUser)) {
        return "";
    }
    $fp = fopen("admin/datos/registrados.txt", "r");
    while (!feof($fp)) {
        $linea = fgets($fp);
        if (strcmp($user, getDato(LINE_USER, $linea)) == 0) {
            break;
        }
        $linea = "";
    }
    fclose($fp);
    if ($linea == "") {
        $errorUser = ERROR_LOGIN_USER;
    }
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

//-------------------------------------- OTROS --------------------------------------

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

/**
 * 
 */
function iniciarSesion($linea)
{
    session_start();
    $_SESSION[SESSION_USER] = getDato(LINE_USER, $linea);
    $_SESSION[SESSION_PASS] = getDato(LINE_PASS, $linea);
    $_SESSION[SESSION_MAIL] = getDato(LINE_MAIL, $linea);
    $_SESSION[SESSION_DATE] = getDato(LINE_DATE, $linea);
    $_SESSION[SESSION_FILE] = getDato(LINE_FILE, $linea);
}

/**
 * Mensaje mostrado al entrar o registrarse
 */
function bienvenido($user, $file)
{
    echo
    "<p class='text-center h4 fw-bold mb-5 mx-1 mx-md-4 mt-4'>
        Bienvenid@ $user
    </p>" .
        "<div class='container text-center main-text'>
        <form action='index.php' method='get'>
            <input type='submit' class='col-md-3 btn btn-primary btn-lg' value='Entrar'>
        </form>
        
        <form action='index.php' method='get'>
            <input type='submit' class='col-md-3 btn btn-secondary btn-lg' value='Salir'>
        </form>
    </div>
    <br/><br/><br/><br/><br/><br/><br/>"
        .
        "
    <div class='col-md-6 card text-black' style='border-radius: 25px;'>
        <img class='contact1-pic' style='margin-left: auto; margin-right: auto;' src='$file'>
    </div>
    ";
    exit();
}
