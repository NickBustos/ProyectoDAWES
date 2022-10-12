<?php
include 'config.php';

//************************************************* */

function vacio($cosa, &$errorCosa)
{
    if (empty($cosa)) {
        $errorCosa = ERROR_VACIO;
        return true;
    }
    return false;
}

/*
* Valida el usuario a la hora de crear el usuario
*/
function validarUser($user, &$errorUser)
{
    if (vacio($user, $errorUser)) {
        return false;
    }
    if (preg_match(PATRON_USER, $user) == false) {
        $errorUser = ERROR_USER_PATRON;
        return false;
    }
    return true;
}

function login($user, $pass, &$errorUser, &$errorPass)
{
    if (vacio($user, $errorUser)) {
        return false;
    }
    $linea = isUsed($user);
    if ($linea == -1) {
        $errorUser = ERROR_LOGIN_USER;
        return false;
    }
    if(vacio($pass, $errorPass)){
        return false;
    }
    if (strcmp($pass, getPassword(recorrer(PATH_TO_BD)[$linea])) != 0){
        $errorPass = ERROR_LOGIN_PASS;
        return false;
    }
    return true;
}

/*
* Valida la contraseña a la hora de crear el usuario
*/
function validarPassword($password, &$errorPassword)
{
    if (strlen($password) < MIN_PASS_LENGTH) {
        $errorPassword = ERROR_PASS_MIN;
        return false;
    }
    if (strlen($password) > MAX_PASS_LENGTH) {
        $errorPassword = ERROR_PASS_MAX;
        return false;
    }
    if (!preg_match(PATRON_PASS_MINUS, $password)) {
        $errorPassword = ERROR_PASS_MINUS;
        return false;
    }
    if (!preg_match(PATRON_PASS_MAYUS, $password)) {
        $errorPassword = ERROR_PASS_MAYUS;
        return false;
    }
    if (!preg_match(PATRON_PASS_NUMBER, $password)) {
        $errorPassword = ERROR_PASS_NUMBER;
        return false;
    }
    return true;
}

function validarBothPasswords($password1, $password2, &$errorPassword1, &$errorPassword2)
{
    if (vacio($password1, $errorPassword1)) {
        return false;
    }
    if (validarPassword($password1, $errorPassword1) == false) {
        return false;
    }
    if (vacio($password2, $errorPassword2)) {
        return false;
    }
    if ($password1 != $password2) {
        $errorPassword2 = ERROR_PASS_MATCH;
        return false;
    }
    return true;
}

/**
 * Funcion para calcular la edad
 * Actualmente esta para que si es menor de edad devuelva false
 * Edad minima 01/01/1900
 * Edad maxima dia actual
 * @param El usuario solamente debe seleccionar una fecha
 */

function mayorEdad($fechanacimiento)
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

function validarFechaNac($fechaNac, &$errorFecha)
{
    if (vacio($fechaNac, $errorFecha)) {
        return false;
    }
    if (mayorEdad($fechaNac) == false) {
        $errorFecha = ERROR_DATE_YEAR;
        return false;
    }
    return true;
}

function validarMail($mail, &$errorMail)
{
    if (vacio($mail, $errorMail)) {
        return false;
    }
    if (filter_var($mail, FILTER_VALIDATE_EMAIL) == false) {
        $errorMail = ERROR_MAIL;
        return false;
    }
    return true;
}

function validarAvatar($files, &$errorFile)
{
    if (
        empty($files) || empty($files["avatar"])
        || empty($files["avatar"]["tmp_name"])
    ) {
        $errorFile = ERROR_VACIO;
        return false;
    }
    if ($files['avatar']['size'] > 1000000) { //1 mega
        $errorFile = ERROR_FILE_SIZE;
        return false;
    }
    return true;
}

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
 * Cuenta numero de imagenes.png en carpeta files
 */
function getNumberOfLogo()
{
    return count(glob(PATH_TO_IMAGENES . '{*.png}', GLOB_BRACE));
}

/**
 * Guardar imagen en carpeta files
 */
function saveImage($file)
{
    if (empty($file) == false) {
        if (is_uploaded_file($file["tmp_name"])) {
            //CREAR CAMINO
            $finalpath = PATH_TO_IMAGENES . getNumberOfLogo() . ".png"; //se puede cambiar y sitio
            return (move_uploaded_file($file["tmp_name"], $finalpath));
            //GUARDAR
        }
    }
}

/**
 * Recorrer un file un txt
 * @param path con nombre del archivo
 */
function recorrer($txt = PATH_TO_BD)
{
    $contadorlinea = 0;
    $lineas = [];
    $fichero = fopen($txt, "r");
    while (!feof($fichero)) {
        $linea = "";
        $linea = fgets($fichero);
        $lineas[$contadorlinea++] = $linea;
    }
    return $lineas;
}

/**
 * Coger usuario de una línea de recorrer
 */
function getUser($linea)
{
    return explode(';', $linea)[0];
}

/**
 * Coger password de una línea de recorrer
 */
function getPassword($linea)
{
    return explode(';', $linea)[1];
}

/**
 * Averigua si un nombre de usuario esta usado en file bbdd
 */
function isUsed($user)
{
    $lineas = recorrer(PATH_TO_BD);

    for ($linea = 0; $linea < sizeof($lineas); $linea++) {
        if (strcmp($user, getUser($lineas[$linea])) == 0) {
            return $linea;
        }
    }
    return -1;
}
